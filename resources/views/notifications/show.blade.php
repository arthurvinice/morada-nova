@extends('app')

@section('title') Notificação @endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title mb-1">{{ $data['titulo'] ?? 'Sem título' }}</h2>
        <div class="card-subtitle mt-0">
            <small><strong>Enviada por:</strong>
                @php

                    $senderText = 'Administrador';
                    $senderClass = 'text-muted';

                    if(isset($notification->data['sender_id']) && $notification->data['sender_id']) {
                        $sender = App\Models\User::find($notification->data['sender_id']);

                        if($sender) {
                            if($sender->nivel === 'Administrador') {
                                $senderText = $sender->name;
                                $senderClass = '';
                            } elseif($sender->nivel === 'SuperAdmin') {
                                $senderText = 'Sistema';
                                $senderClass = 'text-muted';
                            } else {
                                $senderText = 'Administrador';
                                $senderClass = 'text-muted';
                            }
                        }
                    }

                @endphp

                <span class="{{ $senderClass }}">{{ $senderText }}</span>
            </small>

            <i class="icon-base ti tabler-calendar" data-toggle="tooltip" data-placement="left" title="Enviada:  {{ $notification->created_at ? $notification->created_at->format('d/m/Y \à\s H:i') : 'Sem data' }}"></i>
            <i class="icon-base ti tabler-square-check" style="color: #28a745;" data-toggle="tooltip" data-placement="left" title="Lida: {{ $notification->read_at ? $notification->read_at->format('d/m/Y \à\s H:i') : 'Sem data' }}"></i>
        </div>
    </div>
    <div class="card-body">
        <h5>{!! nl2br(e($data['message'] ?? 'Sem mensagem')) !!}</h5>

    </div>

    <div class="card-footer d-flex justify-content-end">
        <a class="btn btn-primary waves-effect" href="{{ url()->previous() }}">Voltar</a>
    </div>

</div>
@endsection
