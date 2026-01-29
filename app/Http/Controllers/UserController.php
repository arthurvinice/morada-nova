<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnSelf;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logado = Auth::user();

        if ($logado->nivel == 'SuperAdmin') {
            $users = User::orderBy('id', 'desc')
                        ->where('is_ativo', true)
                        ->paginate(10);
        } else {
            $users = User::where('departamento_id',$logado->departamento_id)
                        ->where('is_ativo', true)
                        ->orderBy('id', 'desc')
                        ->paginate(10);
        }

        // $users = User::orderBy('id', 'desc')->paginate(10);
        return view('users.index', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        $departamento = $user->departamento_id;

        $departamentos = Department::all();

        return view('users.create', compact('departamento', 'departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'nivel' => 'required|string',
            'whatsapp' => 'nullable|string|max:20',
            'departamento_id' => 'required|integer',
        ]);

        $user = new User();

        // if($request->is_admin == 1){
        //     $user->is_admin = true;
        // }else{
        //     $user->is_admin = false;
        // }

        if($request->is_ativo == 'Ativo'){
            $user->is_ativo = true;
        }else{
            $user->is_ativo = false;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->nivel = $request->nivel;
        $user->whatsapp = $request->whatsapp;

        if (Auth::user()->nivel == 'SuperAdmin') {
            $user->departamento_id = $request->departamento_id;
        } else {
            $user->departamento_id = Auth::user()->departamento_id;
        }
        $user->email_verified_at = now();

        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        if (Auth::user()->nivel != 'SuperAdmin' ) {
            if (Auth::user()->departamento_id != $user->departamento_id){
                return redirect()->back()->with('warning','Você não tem permissão para isso');
            }
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {

        $user = User::find($id);

        $user->name = $request->name;
        $user->nivel = $request->nivel;
        $user->whatsapp = $request->whatsapp;

        if ($request->is_ativo == 'Ativo') {
            $user->is_ativo = true;
        } else {
            $user->is_ativo = false;
        }

        $user->email = $request->email;

        if($request->password){
            $user->password = Hash::make($request->password);
        }


        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Update the password.
     */
    public function updatePassword(UserPasswordUpdateRequest $request, string $id)
    {
        $user = User::find($id);

        if(!Hash::check($request->currentPassword, $user->password)){
            return redirect()->back()->with('warning', 'A sua senha atuação não confere, tentar novamente.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Sua senha foi atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function usersInativos()
    {
        $logado = Auth::user();

        if ($logado->nivel == 'SuperAdmin') {
            $users = User::orderBy('id', 'desc')
                        ->where('is_ativo', false)
                        ->paginate(10);
        } else {
            $users = User::where('departamento_id',$logado->departamento_id)
                        ->where('is_ativo', false)
                        ->orderBy('id', 'desc')
                        ->paginate(10);
        }
        return view('users.inativos', compact('users'));
    }
}
