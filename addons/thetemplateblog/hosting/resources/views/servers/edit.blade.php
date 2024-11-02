@extends('statamic::layout')
@section('title', 'Edit Server')

@section('content')
    <div class="flex items-center justify-between mb-3">
        <h1>Edit Server</h1>
    </div>

    <form action="{{ cp_route('hosting.servers.update', ['index' => $index]) }}" method="POST">
        @csrf
        @method('PATCH')
        
        <div class="card p-4">
            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="name">Server Name</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Give your server a unique name</p>
                </div>
                <input type="text" 
                       name="name" 
                       id="name" 
                       class="input-text" 
                       value="{{ old('name', $server['name']) }}" 
                       required>
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="provider">Provider</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Select your configured provider</p>
                </div>
                <select name="provider" 
                        id="provider" 
                        class="select-input" 
                        required>
                    <option value="">Select a provider</option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider['provider_type'] }}" 
                                {{ old('provider', $server['provider']) == $provider['provider_type'] ? 'selected' : '' }}>
                            {{ $provider['label'] }}
                        </option>
                    @endforeach
                </select>
                @error('provider')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="username">SSH Username</label>
                <div class="help-block -mt-1 mb-1">
                    <p>The SSH username for server access</p>
                </div>
                <input type="text" 
                       name="username" 
                       id="username" 
                       class="input-text" 
                       value="{{ old('username', $server['username']) }}">
                @error('username')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="environment">Environment</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Select the server environment</p>
                </div>
                <select name="environment" 
                        id="environment" 
                        class="select-input" 
                        required>
                    <option value="production" {{ old('environment', $server['environment']) == 'production' ? 'selected' : '' }}>
                        Production
                    </option>
                    <option value="staging" {{ old('environment', $server['environment']) == 'staging' ? 'selected' : '' }}>
                        Staging
                    </option>
                    <option value="development" {{ old('environment', $server['environment']) == 'development' ? 'selected' : '' }}>
                        Development
                    </option>
                </select>
                @error('environment')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="notes">Notes</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Additional notes about this server (optional)</p>
                </div>
                <textarea name="notes" 
                          id="notes" 
                          class="input-text" 
                          rows="3">{{ old('notes', $server['notes']) }}</textarea>
                @error('notes')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="font-bold text-base mb-1">Status</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Current server status</p>
                </div>
                <span class="badge-{{ $server['status'] === 'active' ? 'success' : ($server['status'] === 'maintenance' ? 'warning' : 'danger') }}">
                    {{ ucfirst($server['status']) }}
                </span>
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <a href="{{ cp_route('hosting.servers.index') }}" class="btn mr-2">Cancel</a>
            <button type="submit" class="btn-primary">Update Server</button>
        </div>
    </form>

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
