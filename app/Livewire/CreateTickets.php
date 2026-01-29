<?php

namespace App\Livewire;

use App\Models\Configuration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateTickets extends Component
{
    use WithFileUploads;

    public $titulo;
    public $descricao;
    public $módulo;
    public $uploading = false;
    public $files = [];
    public $newFiles = []; // Para novos arquivos sendo adicionados

    protected $rules = [
        'titulo' => 'required|string|max:255',
        'descricao' => 'required|string',
        'módulo' => 'required|string|max:50',
        'files.*' => 'nullable|file|max:10240|mimes:jpeg,jpg,png,gif,pdf,doc,docx,xls,xlsx,txt,zip,rar',
        'newFiles.*' => 'nullable|file|max:10240|mimes:jpeg,jpg,png,gif,pdf,doc,docx,xls,xlsx,txt,zip,rar',
    ];

    protected $messages = [
        'titulo.required' => 'O título é obrigatório.',
        'titulo.max' => 'O título não pode ter mais de 255 caracteres.',
        'descricao.required' => 'A descrição é obrigatória.',
        'módulo.required' => 'A categoria é obrigatória.',
        'módulo.max' => 'A categoria não pode ter mais de 50 caracteres.',
        'files.*.max' => 'Cada arquivo não pode ser maior que 10MB.',
        'files.*.mimes' => 'Tipo de arquivo não permitido. Use: JPG, PNG, PDF, DOC, XLS, TXT, ZIP.',
        'newFiles.*.max' => 'Cada arquivo não pode ser maior que 10MB.',
        'newFiles.*.mimes' => 'Tipo de arquivo não permitido. Use: JPG, PNG, PDF, DOC, XLS, TXT, ZIP.',
    ];

    public function mount()
    {
        // Método mount sem cache
    }

    public function updatedFiles()
    {
        // Chamado automaticamente quando files é atualizado inicialmente
        \Log::info('Arquivos atualizados via input:', [
            'count' => count($this->files),
            'files' => array_map(function ($file) {
                if (is_object($file) && method_exists($file, 'getClientOriginalName')) {
                    return [
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType()
                    ];
                }
                return 'Invalid file';
            }, $this->files)
        ]);
    }

    public function updatedNewFiles()
    {
        // Quando novos arquivos são selecionados, adicionar aos arquivos existentes
        if (!empty($this->newFiles)) {
            \Log::info('Novos arquivos selecionados:', [
                'count' => count($this->newFiles),
                'existing_count' => count($this->files)
            ]);

            // Adicionar novos arquivos aos existentes
            foreach ($this->newFiles as $file) {
                if ($file && is_object($file) && method_exists($file, 'getClientOriginalName')) {
                    $this->files[] = $file;
                    \Log::info('Arquivo adicionado:', [
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->getSize()
                    ]);
                }
            }

            // Limpar newFiles após adicionar
            $this->newFiles = [];

            \Log::info('Total de arquivos após adição:', ['count' => count($this->files)]);

            // Resetar o input para permitir selecionar os mesmos arquivos novamente se necessário
            $this->dispatch('resetFileInput');
        }
    }

    public function clearAllFiles()
    {
        \Log::info('Limpando todos os arquivos');
        $this->files = [];
        $this->newFiles = [];
        $this->dispatch('resetFileInput');
    }

    public function removeFile($index)
    {
        \Log::info('Removendo arquivo no índice:', ['index' => $index]);

        if (isset($this->files[$index])) {
            // Remover arquivo da lista
            unset($this->files[$index]);
            // Reindexar array
            $this->files = array_values($this->files);

            \Log::info('Arquivo removido. Total restante:', ['count' => count($this->files)]);
        }
    }

    public function submitForm()
    {
        $ticketLogger = \Log::channel('tickets');
        $requestId = uniqid('ticket_', true);

        try {
            $ticketLogger->info("[$requestId] === INICIANDO SUBMIT ===", [
                'user_id' => auth()->id(),
                'titulo' => $this->titulo,
                'modulo' => $this->módulo,
                'files_count' => count($this->files),
                'timestamp' => now()->toDateTimeString()
            ]);

            $this->validate();
            $this->uploading = true;

            $config = Configuration::first();
            $custom_client_id = $config ? $config->custom_client_id : null;
            $user = auth()->user();

            $ticketLogger->info("[$requestId] Configurações carregadas", [
                'custom_client_id' => $custom_client_id,
                'user_name' => $user->name,
                'api_endpoint' => env('ENDPOINT_API_TICKET')
            ]);

            // Preparar dados multipart
            $multipartData = [
                ['name' => 'titulo', 'contents' => $this->titulo],
                ['name' => 'descricao', 'contents' => $this->descricao],
                ['name' => 'módulo', 'contents' => $this->módulo],
                ['name' => 'custom_client_id', 'contents' => $custom_client_id],
                ['name' => 'client_people_id', 'contents' => $user->id],
                ['name' => 'client_people_name', 'contents' => $user->name]
            ];

            // Processar arquivos
            if (!empty($this->files)) {
                foreach ($this->files as $index => $file) {
                    if ($file && is_object($file) && method_exists($file, 'getRealPath')) {
                        $realPath = $file->getRealPath();

                        if (file_exists($realPath)) {
                            $multipartData[] = [
                                'name' => "files[{$index}]",
                                'contents' => fopen($realPath, 'r'),
                                'filename' => $file->getClientOriginalName()
                            ];

                            $ticketLogger->info("[$requestId] Arquivo adicionado", [
                                'index' => $index,
                                'filename' => $file->getClientOriginalName(),
                                'size' => $file->getSize()
                            ]);
                        } else {
                            $ticketLogger->error("[$requestId] Arquivo não encontrado: $realPath");
                        }
                    }
                }
            }

            $ticketLogger->info("[$requestId] Fazendo requisição para API", [
                'endpoint' => env('ENDPOINT_API_TICKET') . '/api/suporte/tickets',
                'multipart_count' => count($multipartData)
            ]);

            // Fazer requisição
            $response = Http::asMultipart()
                ->timeout(60)
                ->post(env('ENDPOINT_API_TICKET') . '/api/suporte/tickets', $multipartData);

            $ticketLogger->info("[$requestId] Resposta recebida", [
                'status_code' => $response->status(),
                'successful' => $response->successful(),
                'response_size' => strlen($response->body()),
                'content_type' => $response->header('Content-Type')
            ]);

            if ($response->successful()) {
                $ticketData = $response->json();
                $ticketLogger->info("[$requestId] Ticket criado com sucesso", [
                    'ticket_id' => $ticketData['id'] ?? 'N/A',
                    'files_uploaded' => count($this->files)
                ]);

                session()->flash('message', 'Ticket criado com sucesso!');
                $this->resetForm();
                return redirect()->route('admin.suporte.ticket.index');
            } else {
                // Log detalhado do erro
                $responseBody = $response->body();
                $responseData = null;

                try {
                    $responseData = $response->json();
                } catch (\Exception $jsonException) {
                    $ticketLogger->error("[$requestId] Erro ao decodificar JSON da resposta", [
                        'json_error' => $jsonException->getMessage(),
                        'raw_response' => substr($responseBody, 0, 1000) // Primeiros 1000 chars
                    ]);
                }

                $ticketLogger->error("[$requestId] Erro na API", [
                    'status_code' => $response->status(),
                    'response_headers' => $response->headers(),
                    'response_body' => $responseBody,
                    'parsed_data' => $responseData
                ]);

                // Log no console do navegador também
                $this->js("console.error('Erro na API:', " . json_encode([
                    'status' => $response->status(),
                    'body' => $responseBody,
                    'data' => $responseData
                ]) . ")");

                $errorMessage = $responseData['message'] ?? 'Erro desconhecido ao criar ticket';
                $this->addError('form', $errorMessage);

                if (isset($responseData['errors'])) {
                    foreach ($responseData['errors'] as $field => $errors) {
                        foreach ($errors as $error) {
                            $this->addError('form', $error);
                        }
                    }
                }
            }
        } catch (ValidationException $e) {
            $ticketLogger->warning("[$requestId] Erro de validação", $e->errors());
            throw $e;
        } catch (\Exception $e) {
            $ticketLogger->error("[$requestId] Erro interno", [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->js("console.error('Erro interno:', " . json_encode($e->getMessage()) . ")");
            $this->addError('form', 'Erro interno: ' . $e->getMessage());
        } finally {
            $this->uploading = false;
            $ticketLogger->info("[$requestId] === FINALIZANDO SUBMIT ===");
        }
    }

    /**
     * Método para limpar o formulário
     */
    public function resetForm()
    {
        $this->reset(['titulo', 'descricao', 'módulo', 'files', 'newFiles']);
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.create-tickets');
    }
}
