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
        return view('users.create');
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
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
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

}
