<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule as ValidationRule;
use Livewire\Component;

class Edit extends Component
{
    public User $user;

    public string $name = '';
    public string $cpf = '';
    public string $email = '';
    public string $phone = '';
    public string $role = '';
    public string $status = '';
    public string $password = '';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->cpf = $user->cpf;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role;
        $this->status = $user->status;
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'cpf' => ['required', 'string', 'max:14', ValidationRule::unique('users', 'cpf')->ignore($this->user->id)],
            'email' => ['required', 'email', 'max:255', ValidationRule::unique('users', 'email')->ignore($this->user->id)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:standard,Administrador,SuperAdmin',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8',
        ];
    }

    public function update()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'status' => $this->status,
        ];

        if (filled($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);

        session()->flash('success', 'Usuário atualizado com sucesso!');

        return redirect()->route('admin.user.index');
    }

    public function render()
    {
        return view('livewire.users.edit');
    }
}