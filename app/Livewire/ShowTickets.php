<?php

namespace App\Livewire;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ShowTickets extends Component
{
    public $ticket = null;
    public $anexos = [];
    public $uuid;
    public $loading = true;

    public function mount($uuid)
    {
        $this->uuid = $uuid;
        $this->loadTicket();
        $this->loadAnexos();
    }

    public function loadTicket()
    {
        try {
            $this->loading = true;

            $response = Http::get(env('ENDPOINT_API_TICKET') . "/api/suporte/tickets/{$this->uuid}");

            if ($response->successful()) {
                $this->ticket = json_decode($response->body());
                if ($this->ticket && $this->ticket->created_at) {
                    $this->ticket->created_at = Carbon::parse($this->ticket->created_at);
                }
                if ($this->ticket && $this->ticket->updated_at) {
                    $this->ticket->updated_at = Carbon::parse($this->ticket->updated_at);
                }
            } else {
                session()->flash('error', 'Ticket não encontrado');
                return redirect()->route('admin.suporte.ticket.index');
            }
        } catch (Exception $e) {
            session()->flash('error', 'Erro de conexão com a API');
            return redirect()->route('admin.suporte.ticket.index');
        } finally {
            $this->loading = false;
        }
    }

    public function loadAnexos()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->get(env('ENDPOINT_API_TICKET') . "/api/suporte/anexos/ticket/{$this->uuid}");

            if ($response->successful()) {
                $responseData = $response->json();

                if ($responseData['success'] && isset($responseData['anexos'])) {
                    $this->anexos = collect($responseData['anexos']);
                } else {
                    $this->anexos = collect();
                }
            } else {
                $this->anexos = collect();
                \Log::warning('Erro ao carregar anexos', [
                    'uuid' => $this->uuid,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
            }
        } catch (Exception $e) {
            $this->anexos = collect();
            \Log::error('Erro ao carregar anexos', [
                'uuid' => $this->uuid,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Fazer download de um anexo
     */
    public function downloadAnexo($anexoId)
    {
        try {
            return redirect()->to(env('ENDPOINT_API_TICKET') . "/api/suporte/anexos/{$anexoId}/download");
        } catch (Exception $e) {
            session()->flash('error', 'Erro ao fazer download do arquivo');
        }
    }

    public function render()
    {
        return view('livewire.show-tickets');
    }
}
