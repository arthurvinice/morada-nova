@extends('app')

@section('title') Dashboard @endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />

@endpush

@section('content')

    @livewire('dash.superadmin-index')

@endsection

@push('scripts')

    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>

@endpush
