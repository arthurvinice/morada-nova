<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Notifications\UsersNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('notifications.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $departamento = Department::where('id', auth()->user()->department_id);
        return view('notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mensagem' => 'required|string',
            'titulo' => 'required|string',
            'sender_id' => 'nullable|exists:users,id',
        ]);

        $departamentoId = auth()->user()->departamento_id;
        $user_id = auth()->user()->id;

        if(auth()->user()->nivel == 'SuperAdmin'){
            $usuarios = User::all();
            foreach ($usuarios as $usuario) {
                $usuario->notify(new UsersNotification($request->mensagem, $request->titulo, $user_id));
            }
        } else {
            $usuarios = User::where('departamento_id', $departamentoId)
                        ->get();
            foreach ($usuarios as $usuario) {
            $usuario->notify(new UsersNotification($request->mensagem, $request->titulo, $user_id));
        }
        }


        return redirect()->back()->with('success', 'Notificação enviada com sucesso!');
    }

    // public function markAsRead($id)
    // {
    //     $notification = auth()->user()->unreadNotifications()->find($id);

    //     if ($notification) {
    //         $notification->markAsRead();
    //         return response()->json(['message' => 'Notificação marcada como lida.']);
    //     }

    //     return response()->json(['message' => 'Notificação não encontrada.'], 404);
    // }

    // public function markAllAsRead()
    // {
    //     auth()->user()->unreadNotifications->markAsRead();

    //     return response()->json(['message' => 'Todas notificações marcadas como lidas.']);
    // }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        $data = $notification->data;

        return view('notifications.show', compact('notification', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
