@extends('statamic::layout')
@section('title', 'Hosting')

@section('content')
    <div class="flex items-center justify-between mb-3">
        <h1>Servers</h1>
        <a href="{{ cp_route('hosting.servers.create') }}" class="btn-primary">Add Server</a>
    </div>

    <div class="card p-0">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>IP Address</th>
                    <th>Provider</th>
                    <th>Status</th>
                    <th>Environment</th>
                    <th class="actions-column"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($servers as $server)
                <tr>
                    <td>{{ $server->get('title') }}</td>
                    <td>{{ $server->get('ip_address') }}</td>
                    <td>{{ ucfirst($server->get('provider')) }}</td>
                    <td>
                        <span class="badge-{{ $server->get('status') === 'active' ? 'success' : ($server->get('status') === 'maintenance' ? 'warning' : 'danger') }}">
                            {{ ucfirst($server->get('status')) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-{{ $server->get('environment') === 'production' ? 'danger' : ($server->get('environment') === 'staging' ? 'warning' : 'success') }}">
                            {{ ucfirst($server->get('environment')) }}
                        </span>
                    </td>
                    <td class="flex justify-end">
                        <div class="btn-group">
                            <a href="{{ $server->editUrl() }}" class="btn btn-small">Edit</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center p-3">No servers found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
