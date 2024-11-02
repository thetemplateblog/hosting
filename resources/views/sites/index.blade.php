@extends('statamic::layout')
@section('title', 'Sites')

@section('content')
    <div class="flex items-center justify-between mb-3">
        <h1>Sites</h1>
        @if(!empty($servers))
            <a href="{{ cp_route('hosting.sites.create') }}" class="btn-primary">Add Site</a>
        @else
            <a href="{{ cp_route('hosting.servers.create') }}" class="btn-primary">Configure Server First</a>
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

    @if(empty($servers))
        <div class="card p-4">
            <p class="text-gray-700">You need to configure at least one server before you can add sites.</p>
            <p class="mt-2">
                <a href="{{ cp_route('hosting.servers.create') }}" class="text-blue-600 hover:text-blue-800">
                    Click here to add your first server
                </a>
            </p>
        </div>
    @else
        <div class="card p-0">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Domain</th>
                        <th>Server</th>
                        <th>Status</th>
                        <th class="actions-column"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sites as $index => $site)
                    <tr>
                        <td>{{ $site['name'] }}</td>
                        <td>{{ $site['domain'] }}</td>
                        <td>
                            @php
                                $server = $servers[$site['server_index']] ?? null;
                            @endphp
                            {{ $server ? $server['name'] : 'Unknown Server' }}
                        </td>
                        <td>
                            <span class="badge-{{ $site['status'] === 'active' ? 'success' : ($site['status'] === 'maintenance' ? 'warning' : 'danger') }}">
                                {{ ucfirst($site['status']) }}
                            </span>
                        </td>
                        <td class="flex justify-end">
                            <div class="btn-group">
                                <a href="{{ cp_route('hosting.sites.edit', ['index' => $index]) }}" class="btn btn-small">Edit</a>
                                <form 
                                    method="POST" 
                                    action="{{ cp_route('hosting.sites.destroy', ['index' => $index]) }}" 
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit"
                                        class="btn btn-small"
                                        onclick="return confirm('Are you sure you want to delete this site?')"
                                    >Delete</button>
                                </form>

                                {{-- Deploy Button --}}
                                <form 
                                    method="POST" 
                                    action="{{ cp_route('hosting.sites.deploy.single', ['index' => $index]) }}" 
                                    class="inline">
                                    @csrf
                                    <button 
                                        type="submit"
                                        class="btn btn-small text-green-600"
                                        onclick="return confirm('Are you sure you want to deploy this site?')"
                                    >Deploy</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-3">No sites found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    <style>
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
