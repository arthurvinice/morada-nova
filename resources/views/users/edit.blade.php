@extends('app')

@section('title') Editar Usuário no Sitema @endsection

@push('styles')
    <link href="{{ asset('assets/vendor/libs/select2/select2.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

@livewire('users.edit', ['user' => $user])

@endsection

@push('scripts')
<script src="{{ asset('assets/js/form-layouts.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function(){
            $('.cep').mask('00000-000');
            $('.phone_with_ddd').mask('(00) 00000-0000');
            $('.cpf').mask('000.000.000-00', {reverse: true});
        });
    </script>
@endpush
