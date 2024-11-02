@extends('statamic::layout')
@section('title', 'Servers')

@section('content')
    <div class="flex items-center justify-between mb-3">
        <h1>Servers</h1>
        @if(!empty($providers))
            <a href="{{ cp_route('hosting.servers.create') }}" class="btn-primary">Add Server</a>
        @else
            <a href="{{ cp_route('hosting.providers.create') }}" class="btn-primary">Configure Provider First</a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if(empty($providers))
        <div class="card p-4">
            <p class="text-gray-700">You need to configure at least one provider before you can add servers.</p>
            <p class="mt-2">
                <a href="{{ cp_route('hosting.providers.create') }}" class="text-blue-600 hover:text-blue-800">Click here to add your first provider</a>
            </p>
        </div>
    @else
        <div class="card p-0">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Provider</th>
                        <th>Username</th>
                        <th>Environment</th>
                        <th>Status</th>
                        <th class="actions-column"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servers as $index => $server)
                    <tr>
                        <td>
                            <a href="{{ cp_route('hosting.servers.show', ['index' => $index]) }}" class="text-blue-600 hover:text-blue-800">
                                {{ $server['name'] }}
                            </a>
                        </td>
                        <td>
                            @php
                                $provider = collect($providers)->firstWhere('provider_type', $server['provider']);
                            @endphp
                            {{ $provider ? $provider['label'] : ucfirst($server['provider']) }}
                        </td>
                        <td>{{ $server['username'] }}</td>
                        <td>
                            <span class="badge-{{ $server['environment'] }}">
                                {{ ucfirst($server['environment']) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-{{ $server['status'] === 'active' ? 'success' : ($server['status'] === 'maintenance' ? 'warning' : 'danger') }}">
                                {{ ucfirst($server['status']) }}
                            </span>
                        </td>
                        <td class="flex justify-end">
                            <div class="btn-group">
                                <a href="{{ cp_route('hosting.servers.edit', ['index' => $index]) }}" class="btn btn-small">Edit</a>
                                <form 
                                    method="POST" 
                                    action="{{ cp_route('hosting.servers.destroy', ['index' => $index]) }}" 
                                    class="inline"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit"
                                        class="btn btn-small"
                                        onclick="return confirm('Are you sure you want to delete this server?')"
                                    >Delete</button>
                                </form>
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
    @endif

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
        .btn-group form {
            display: inline-block;
        }
        .btn-group form button {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
    </style>
@endsection
