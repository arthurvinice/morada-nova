<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();



        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|unique:users,cpf',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|string',
            'image' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $user = new User();

            if ($request->status == 'active') {
                $user->status = true;
            } else {
                $user->status = false;
            }

            $user->name = $request->name;
            $user->cpf = $request->cpf;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->whatsapp = $request->whatsapp;
            $user->image = $request->image;

            $user->email_verified_at = now();

            $user->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao criar usuário: ' . $e->getMessage());
        }

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

        if (auth()->user()->id !== $user->id && auth()->user()->nivel !== 'SuperAdmin') {
            return redirect()->route('admin.user.index')->with('warning', 'Acesso negado!');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {

        $user = User::findOrFail($id);


        $user->name = $request->name;
        $user->role = $request->role;
        $user->whatsapp = $request->whatsapp;

        if ($request->status == 'Ativo') {
            $user->status = true;
        } else {
            $user->status = false;
        }

        $user->email = $request->email;

        if ($request->password) {
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

        if (!Hash::check($request->currentPassword, $user->password)) {
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
            $users = User::where('departamento_id', $logado->departamento_id)
                ->where('is_ativo', false)
                ->orderBy('id', 'desc')
                ->paginate(10);
        }
        return view('users.inativos', compact('users'));
    }
}
