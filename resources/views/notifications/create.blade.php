@extends('app')

@section('title')
    Criar Notificação
@endsection

@push('styles')

@endpush

@section('content')
    <div class="container">
        <h2>Criar Notificação</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.notification.store') }}" method="POST">
            @csrf
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">

                            <h5 class="card-header pb-4">
                                Título
                            </h5>
                            <div class="card-body pb-2">
                                <input class="form-control" type="text" name="titulo" id="titulo" required>
                            </div>

                            <h5 class="card-header pt-3 pb-4">Descrição</h5>
                            <div class="card-body pt-0">
                                <textarea class="form-control" name="mensagem" id="mensagem" cols="50" rows="8"></textarea>
                            </div>


                            <div class="mt-3 mb-5 me-5 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Enviar Notificação</button>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.tiny.cloud/1/xon7ej4c60h2leoi6valwx200370s1oiftejxjpawc49ntnv/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
@endpush
