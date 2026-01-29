<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Address;
use App\Models\People;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $configurations = Configuration::latest()->get();
        return view('configurations.index', compact('configurations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $configurations = Configuration::all();
        return view('configurations.create', compact('configurations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_fantasia'      => 'required|string|max:255',
            'razao_social'       => 'required|string|max:255',
            'cnpj'               => 'required|string|max:20',
            'telefone_principal' => 'required|string|max:20',
            'whatsapp'           => 'required|string|max:20',
            'email'              => 'required|email|max:255',
            'logo'               => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'avatar'             => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            // Validação dos campos de endereço
            'rua'             => 'required|string|max:255',
            'numero'             => 'required|string|max:255',
            'bairro'             => 'required|string|max:255',
            'cidade'               => 'required|string|max:255',
            'cep'               => 'required|string|max:9',
            'estado'              => 'required|string|max:255',
            'custom_client_id'   => 'nullable|string|max:255',
        ]);


        // Prepara os dados para a configuração
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('configurations/logos', 'public');
        }
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('configurations/avatars', 'public');
        }

        Configuration::create($validated);

        return redirect()->route('admin.configurations.index')
        ->with('success', 'Configuração criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Configuration $configuration)
    {
        return view('configurations.show', compact('configuration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $configuration = Configuration::findOrFail($id);
        return view('configurations.edit', compact('configuration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Configuration $configuration)
    {
        $validated = $request->validate([
            'nome_fantasia'      => 'required|string|max:255',
            'razao_social'       => 'required|string|max:255',
            'cnpj'               => 'required|string|max:20',
            'telefone_principal' => 'required|string|max:20',
            'whatsapp'           => 'required|string|max:20',
            'email'              => 'required|email|max:255',
            'logo'               => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'avatar'             => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'address_id'         => 'nullable|exists:addresses,id',
            // Validação dos campos de endereço
            'rua'             => 'required|string|max:255',
            'numero'             => 'required|string|max:255',
            'bairro'             => 'required|string|max:255',
            'cidade'               => 'required|string|max:255',
            'cep'               => 'required|string|max:9',
            'estado'              => 'required|string|max:255',
            'custom_client_id'   => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('logo')) {
            if ($configuration->logo && Storage::disk('public')->exists($configuration->logo)) {
                Storage::disk('public')->delete($configuration->logo);
            }
            $validated['logo'] = $request->file('logo')->store('configurations/logos', 'public');
        }
        if ($request->hasFile('avatar')) {
            if ($configuration->avatar && Storage::disk('public')->exists($configuration->avatar)) {
                Storage::disk('public')->delete($configuration->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('configurations/avatars', 'public');
        }

        $configuration->update($validated);

        return redirect()->route('admin.configurations.show', $configuration)
            ->with('success', 'Configuração atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Configuration $configuration)
    {
        if ($configuration->logo && Storage::disk('public')->exists($configuration->logo)) {
            Storage::disk('public')->delete($configuration->logo);
        }
        if ($configuration->avatar && Storage::disk('public')->exists($configuration->avatar)) {
            Storage::disk('public')->delete($configuration->avatar);
        }

        $configuration->delete();

        return redirect()->route('admin.configurations.index')
        ->with('success', 'Configuração excluída com sucesso!');
    }

    //função para mostrar o index do backup de people
    public function backupPeopleIndex()
    {
        $backups = Storage::disk('public')->files('people/backups');

        $backups = array_filter($backups, function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'csv';
        });
        return view('configurations.backup', compact('backups'));
    }

    //função para gerar um backup em csv de todos os registros de people
    public function generateBackup()
    {
        $people = People::all();
        $csvFileName = 'people_backup_' . now()->format('Y_m_d_H_i_s') . '.csv';
        $filePath = 'people/backups/' . $csvFileName;

        //verificar se o diretorio people/backups existe, se não existir, criar
        if (!Storage::disk('public')->exists('people/backups')) {
            Storage::disk('public')->makeDirectory('people/backups');
        }

        $handle = fopen(storage_path('app/public/' . $filePath), 'w');
        fputcsv($handle, ['ID', 'Nome', 'Apelido', 'CPF', 'Whatsapp', 'Gênero','Escolaridade', 'Data Nascimento', 'Rua', 'Número', 'Bairro', 'Cidade', 'CEP', 'UF', 'Complemento']);




        foreach ($people as $person) {

            //tirar ponto e hifen do cpf
            $cpfNumerico = preg_replace('/[^0-9]/', '', $person->cpf);

            //tirar 55 do whatsapp
            $wpp = $person->whatsapp;
            $wpp = preg_replace('/^\+?55/', '', $wpp);

            $dataNascimento = $person->date_nascimento ?
                Carbon::parse($person->date_nascimento)->format('Y-m-d') : '';

            fputcsv($handle, [
                $person->id,
                $person->nome,
                $person->apelido,
                $cpfNumerico,
                $wpp,
                $person->genero,
                $person->escolaridade ?? '',
                $dataNascimento,
                $person->rua,
                $person->numero,
                $person->bairro,
                $person->cidade,
                $person->cep,
                $person->uf,
                $person->complemento
            ]);
        }

        fclose($handle);

        return redirect()->back()->with('success', 'Backup criado com sucesso!');

    }

    public function downloadBackup($filename)
    {
        // Validação básica do nome do arquivo para segurança
        if (!preg_match('/^people_backup_\d{4}_\d{2}_\d{2}_\d{2}_\d{2}_\d{2}\.csv$/', $filename)) {
            abort(404, 'Arquivo inválido');
        }

        $filePath = 'people/backups/' . $filename;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'Arquivo não encontrado');
        }

        $fullPath = storage_path('app/public/' . $filePath);

        // Verificar se o arquivo realmente existe no sistema de arquivos
        if (!file_exists($fullPath)) {
            abort(404, 'Arquivo não encontrado no sistema');
        }

        return response()->download($fullPath, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

}
