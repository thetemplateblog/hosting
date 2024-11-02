@extends('statamic::layout')
@section('title', $server['name'])

@section('content')
    <div class="flex items-center justify-between mb-3">
        <h1>{{ $server['name'] }}</h1>
        <div class="flex">
            <a href="{{ cp_route('hosting.servers.edit', ['index' => $index]) }}" class="btn-primary">Edit Server</a>
        </div>
    </div>

    <div class="card p-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="font-bold mb-1">Provider</h3>
                <p>{{ collect(config('hosting.providers'))->firstWhere('provider_type', $server['provider'])['label'] }}</p>
            </div>
            
            <div>
                <h3 class="font-bold mb-1">Environment</h3>
                <p><span class="badge-{{ $server['environment'] }}">{{ ucfirst($server['environment']) }}</span></p>
            </div>

            <div>
                <h3 class="font-bold mb-1">SSH Username</h3>
                <p>{{ $server['username'] }}</p>
            </div>

            <div>
                <h3 class="font-bold mb-1">Status</h3>
                <p><span class="badge-{{ $server['status'] === 'active' ? 'success' : ($server['status'] === 'maintenance' ? 'warning' : 'danger') }}">
                    {{ ucfirst($server['status']) }}
                </span></p>
            </div>
        </div>

        @if($server['notes'])
        <div class="mt-4">
            <h3 class="font-bold mb-1">Notes</h3>
            <p class="whitespace-pre-wrap">{{ $server['notes'] }}</p>
        </div>
        @endif
    </div>

    <style>
        .badge-production {
            @apply inline-block px-2 py-1 text-xs font-bold rounded bg-green-100 text-green-800;
        }
        .badge-staging {
            @apply inline-block px-2 py-1 text-xs font-bold rounded bg-yellow-100 text-yellow-800;
        }
        .badge-development {
            @apply inline-block px-2 py-1 text-xs font-bold rounded bg-blue-100 text-blue-800;
        }
        .badge-success {
            @apply inline-block px-2 py-1 text-xs font-bold rounded bg-green-100 text-green-800;
        }
        .badge-warning {
            @apply inline-block px-2 py-1 text-xs font-bold rounded bg-yellow-100 text-yellow-800;
        }
        .badge-danger {
            @apply inline-block px-2 py-1 text-xs font-bold rounded bg-red-100 text-red-800;
        }
    </style>
@endsection
