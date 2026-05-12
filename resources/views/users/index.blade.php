@extends('app')

@section('title') Usuários do sitema - {{env('APP_NAME')}} @endsection

@section('content')

    @livewire('users.index')

@endsection
