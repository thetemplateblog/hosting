@extends('statamic::layout')
@section('title', 'Edit Site')

@section('content')
    <div class="flex items-center justify-between mb-3">
        <h1>Edit Site</h1>
    </div>

    <form action="{{ cp_route('hosting.sites.update', ['index' => $index]) }}" method="POST">
        @csrf
        @method('PATCH')
        
        <div class="card p-4">
            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="name">Site Name</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Give your site a name</p>
                </div>
                <input type="text" 
                       name="name" 
                       id="name" 
                       class="input-text" 
                       value="{{ old('name', $site['name']) }}" 
                       required>
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="domain">Domain</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Enter the domain name</p>
                </div>
                <input type="text" 
                       name="domain" 
                       id="domain" 
                       class="input-text" 
                       value="{{ old('domain', $site['domain']) }}"
                       required>
                @error('domain')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="server_index">Server</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Select the server to host this site</p>
                </div>
                <select name="server_index" 
                        id="server_index" 
                        class="select-input" 
                        required>
                    <option value="">Select a server</option>
                    @foreach($servers as $index => $server)
                        <option value="{{ $index }}" 
                                {{ old('server_index', $site['server_index']) == $index ? 'selected' : '' }}
                                data-environment="{{ $server['environment'] }}">
                            {{ $server['name'] }} ({{ ucfirst($server['environment']) }})
                        </option>
                    @endforeach
                </select>
                <div id="server-environment" class="text-sm text-gray-500 mt-1"></div>
                @error('server_index')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="font-bold text-base mb-1">Status</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Current site status</p>
                </div>
                <span class="badge-{{ $site['status'] === 'active' ? 'success' : ($site['status'] === 'maintenance' ? 'warning' : 'danger') }}">
                    {{ ucfirst($site['status']) }}
                </span>
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <a href="{{ cp_route('hosting.sites.index') }}" class="btn mr-2">Cancel</a>
            <button type="submit" class="btn-primary">Update Site</button>
        </div>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('server_index');
            const envDiv = document.getElementById('server-environment');

            function updateEnvironmentInfo() {
                const selected = select.options[select.selectedIndex];
                if (selected.value) {
                    const env = selected.getAttribute('data-environment');
                    const envClass = {
                        'production': 'text-green-600',
                        'staging': 'text-yellow-600',
                        'development': 'text-blue-600'
                    }[env] || 'text-gray-600';
                    
                    envDiv.innerHTML = `<span class="${envClass}">Server Environment: ${env.charAt(0).toUpperCase() + env.slice(1)}</span>`;
                } else {
                    envDiv.innerHTML = '';
                }
            }

            select.addEventListener('change', updateEnvironmentInfo);
            updateEnvironmentInfo();
        });
    </script>
    @endpush

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
