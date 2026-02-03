@extends('app')

@section('title')
    Dashboard
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link href="{{ asset('assets/vendor/libs/select2/select2.css') }}" rel="stylesheet" />

@endpush

@section('content')
    @include('_inc.alerts')

    @livewire('people.index')
@endsection

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.44.0/apexcharts.min.js"></script>


    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>


    {{-- <script src="{{ asset('assets/js/ui-modals.js') }}"></script> --}}
@endpush
