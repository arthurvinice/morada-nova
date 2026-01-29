@extends('app')

@section('title') Backup de Pessoas @endsection

@push('styles')

@endpush

@section('content')

@include('_inc.alerts')

<div class="card mt-6">
    <div class="card-header row">

        <h4 class="card-title">Histórico de Backups</h4>

        <div class="col-12 d-flex align-items-center justify-content-end">

            <a href="{{ route('admin.backup.generate') }}" type="button" class="btn btn-primary waves-effect waves-light">Gerar Backup</a>

        </div>

    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
            <tr>
            <th>Nº</th>
            <th>Arquivo</th>
            <th>Data</th>
            <th>Ações</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($backups as $index => $backup)
            <tr>
                <td>{{ $index + 1 }}</td>

                <td>{{ basename($backup) }}</td>

                <td>{{ \Carbon\Carbon::createFromTimestamp(Storage::disk('public')->lastModified($backup))->format('d/m/Y H:i') }}</td>

                <td>
                <a href="{{ route('admin.backup.download', basename($backup)) }}" class="btn btn-sm btn-primary">Download</a>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
