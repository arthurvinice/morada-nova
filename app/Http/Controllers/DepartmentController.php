<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {

        if(Auth::user()->nivel != "SuperAdmin"){
            return redirect()->back()->with('warning','Você não tem permissão para acessar esta página');
        }

        $departments = Department::orderBy('id', 'desc')->paginate();
        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Department $department)
    {

        $request->validate([
            'nome' => 'required|string|max:100',
            'cnpj' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,bmp,png',
            'email' => 'required|email|max:150',
            'telefone_principal' => 'required|string|max:255',
            'telefone_secundario' => 'nullable|string|max:255',
            'rua' => 'nullable|string|max:100',
            'numero' => 'nullable|string|max:10',
            'bairro' => 'nullable|string|max:50',
            'cidade' => 'nullable|string|max:50',
            'cep' => 'nullable|string|max:255',
            'uf' => 'nullable|string|max:255',
            'complemento' => 'nullable|string|max:100',
            'send_message' => 'boolean',
            'webhook_n8n_campaign' => 'nullable|string|max:255|url:https',
        ]);

        DB::beginTransaction();

        try {
            $department = new Department();

            $department->nome = ucwords(strtolower($request->nome));

            if ($request->hasFile('logo')) {
                if ($department->logo) {
                    Storage::disk('public')->delete($department->logo);
                }
                $validated['logo'] = $request->file('logo')->store('departments/logos', 'public');
            }

            $department->email = $request->email;
            $department->telefone_principal = $request->telefone_principal;
            $department->telefone_secundario = $request->telefone_secundario;
            $department->rua = ucwords(strtolower($request->rua));
            $department->numero = $request->numero;
            $department->bairro = ucwords(strtolower($request->bairro));
            $department->cidade = ucwords(strtolower($request->cidade));
            $department->cep = $request->cep;
            $department->uf = $request->uf;
            $department->complemento = $request->complemento;
            // $department->webhook_n8n_service = $request->webhook_n8n_service;
            // $department->webhook_n8n_order = $request->webhook_n8n_order;
            $department->webhook_n8n_campaign = $request->webhook_n8n_campaign;


            //verifica se o campo webhook_n8n_service está vazio
            if($request->send_message == 1){

                if($department->webhookn8n_service == null){

                    $request->validate([
                        'webhook_n8n_service' => 'required|string|max:255|url:https',
                    ]);
                }

                $department->send_message = true;

            } else {
                $department->send_message = false;
            }

            //verifica se o campo webhook_n8n_order está vazio
            if($request->send_message == 1){

                if($department->webhookn8n_order == null){

                    $request->validate([
                        'webhookn8n_order' => 'required|string|max:255|url:https',
                    ]);
                }

                $department->send_message = true;

            } else {
                $department->send_message = false;
            }

            //verifica se o campo webhook_n8n_campaign está vazio
            if($request->send_message == 1){

                if($department->webhookn8n_campaign == null){

                    $request->validate([
                        'webhook_n8n_campaign' => 'required|string|max:255|url:https',
                    ]);
                }

                $department->send_message = true;

            } else {
                $department->send_message = false;
            }

            $department->save();

            DB::commit();

            return redirect()->route('admin.departments.index')->with('success', 'Setor cadastrado com sucesso.');

        } catch (Exception $e){

            DB::rollBack();

            return redirect()->back()->with('warning','Erro: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $department = Department::findOrFail($id);

        //verificar se o usuário é SuperAdmin ou se o departamento é o mesmo do usuário
        if (
                $user->nivel !== 'SuperAdmin' && (
                    $user->nivel !== 'Administrador' || $department->id !== $user->departamento_id
                )
            ) {
                return redirect()->back()->with('warning', 'Você não tem permissão para acessar esta página');
            }

        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'nome' => 'required|string|max:100',
            'cnpj' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,bmp,png',
            'email' => 'required|email|max:150',
            'telefone_principal' => 'required|string|max:255',
            'telefone_secundario' => 'nullable|string|max:255',
            'rua' => 'nullable|string|max:100',
            'numero' => 'nullable|string|max:10',
            'bairro' => 'nullable|string|max:50',
            'cidade' => 'nullable|string|max:50',
            'cep' => 'nullable|string|max:255',
            'uf' => 'nullable|string|max:255',
            'complemento' => 'nullable|string|max:100',
            'send_message' => 'boolean',
            'webhook_n8n_campaign' => 'nullable|string|max:255|url:https',
        ]);

        DB::beginTransaction();

        try {
            $department = Department::findOrFail($id);

            $department->nome = ucwords(strtolower($request->nome));

            if ($request->hasFile('logo')) {
                if ($department->logo) {
                    Storage::disk('public')->delete($department->logo);
                }
                $validated['logo'] = $request->file('logo')->store('departments/logos', 'public');
            }

            $department->email = $request->email;
            $department->cnpj = $request->cnpj;
            $department->telefone_principal = $request->telefone_principal;
            $department->telefone_secundario = $request->telefone_secundario;
            $department->rua = ucwords(strtolower($request->rua));
            $department->numero = $request->numero;
            $department->bairro = ucwords(strtolower($request->bairro));
            $department->cidade = ucwords(strtolower($request->cidade));
            $department->cep = $request->cep;
            $department->uf = $request->uf;
            $department->complemento = $request->complemento;
            $department->webhook_n8n_campaign = $request->webhook_n8n_campaign;


            //verifica se o campo webhook_n8n_service está vazio
            // if($request->send_message == 1){

            //     if($department->webhook_n8n_service == null){

            //         $request->validate([
            //             'webhook_n8n_service' => 'required|string|max:255|url:https',
            //         ]);
            //         $department->webhook_n8n_service = $request->webhook_n8n_service;
            //     }

            //     $department->send_message = true;

            // } else {
            //     $department->send_message = false;
            // }

            //verifica se o campo _n8n_order está vazio
            // if($request->send_message == 1){

            //     if($department->webhook_n8n_order == null){

            //         $request->validate([
            //             'webhook_n8n_order' => 'required|string|max:255|url:https',
            //         ]);
            //         $department->webhook_n8n_order = $request->webhook_n8n_order;
            //     }

            //     $department->send_message = true;

            // } else {
            //     $department->send_message = false;
            // }

            //verifica se o campo webhook_n8n_campaign está vazio
            if($request->send_message == 1){

                if($department->webhook_n8n_campaign == null){

                    $request->validate([
                        'webhook_n8n_campaign' => 'required|string|max:255|url:https',
                    ]);
                    $department->webhook_n8n_campaign = $request->webhook_n8n_campaign;
                }

                $department->send_message = true;

            } else {
                $department->send_message = false;
            }


            $department->save();

            DB::commit();

            if (Auth::user()->nivel == "SuperAdmin") {
                return redirect()->route('admin.departments.index')->with('success','Setor atualizado com sucesso!');
            }
            return redirect()->route('admin.service.index')->with('success','Setor atualizado com sucesso!');


        } catch(Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('warning','Erro: ' . $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
