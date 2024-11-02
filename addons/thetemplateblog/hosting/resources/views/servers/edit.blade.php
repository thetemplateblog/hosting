@extends('statamic::layout')
@section('title', 'Edit Server')

@section('content')
    <div class="flex items-center justify-between mb-3">
        <h1>Edit Server</h1>
    </div>

    <form action="{{ cp_route('hosting.servers.update', ['index' => $index]) }}" method="POST">
        @csrf
        @method('PATCH')
        
        <div class="max-w-lg mt-3">
            <div class="card p-4">
                <div class="mb-4">
                    <label class="font-bold text-base mb-1" for="name">Server Name</label>
                    <div class="text-sm text-gray-500 mb-1">Give your server a unique name</div>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           class="input-text" 
                           value="{{ old('name', $server['name']) }}" 
                           required>
                </div>

                <div class="mb-4">
                    <label class="font-bold text-base mb-1" for="provider">Provider</label>
                    <div class="text-sm text-gray-500 mb-1">Select your hosting provider</div>
                    <select name="provider" 
                            id="provider" 
                            class="select-input" 
                            required>
                        @foreach(config('hosting.providers') as $provider)
                            <option value="{{ $provider['provider_type'] }}" 
                                    {{ old('provider', $server['provider']) == $provider['provider_type'] ? 'selected' : '' }}>
                                {{ $provider['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="font-bold text-base mb-1" for="username">SSH Username</label>
                    <div class="text-sm text-gray-500 mb-1">The SSH username for server access</div>
                    <input type="text" 
                           name="username" 
                           id="username" 
                           class="input-text" 
                           value="{{ old('username', $server['username']) }}">
                </div>

                <div class="mb-4">
                    <label class="font-bold text-base mb-1" for="environment">Environment</label>
                    <div class="text-sm text-gray-500 mb-1">Select the server environment</div>
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
                </div>


                <div class="mb-4">
                    <label class="font-bold text-base mb-1" for="notes">Notes</label>
                    <div class="text-sm text-gray-500 mb-1">Additional notes about this server</div>
                    <textarea name="notes" 
                              id="notes" 
                              class="input-text" 
                              rows="3">{{ old('notes', $server['notes']) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <a href="{{ cp_route('hosting.servers.index') }}" class="btn mr-2">Cancel</a>
                <button type="submit" class="btn-primary">Save</button>
            </div>
        </div>
    </form>
@endsection
