@extends('statamic::layout')
@section('title', 'Add Server')

@section('content')
    <div class="flex items-center justify-between mb-3">
        <h1>Add New Server</h1>
    </div>

    <form action="{{ cp_route('hosting.servers.store') }}" method="POST">
        @csrf
        
        <div class="max-w-lg mt-3">
            <div class="card p-2">
                <div class="p-3">
                    <div class="mb-5">
                        <label class="font-bold text-base mb-1" for="name">Server Name</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               class="input-text @error('name') border-red-500 @enderror" 
                               value="{{ old('name') }}" 
                               required>
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="font-bold text-base mb-1" for="provider">Provider</label>
                        <select name="provider" 
                                id="provider" 
                                class="select-input @error('provider') border-red-500 @enderror" 
                                required>
                            <option value="">Select a provider</option>
                            @foreach(config('hosting.providers') as $provider)
                                <option value="{{ $provider['provider_type'] }}" 
                                        {{ old('provider') == $provider['provider_type'] ? 'selected' : '' }}
                                        data-description="{{ $provider['description'] }}">
                                    {{ $provider['label'] }}
                                </option>
                            @endforeach
                        </select>
                        <div id="provider-description" class="text-sm text-gray-500 mt-1"></div>
                        @error('provider')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="font-bold text-base mb-1" for="username">SSH Username</label>
                        <input type="text" 
                               name="username" 
                               id="username" 
                               class="input-text @error('username') border-red-500 @enderror" 
                               value="{{ old('username', 'root') }}">
                        @error('username')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="font-bold text-base mb-1" for="environment">Environment</label>
                        <select name="environment" 
                                id="environment" 
                                class="select-input @error('environment') border-red-500 @enderror" 
                                required>
                            <option value="production" {{ old('environment') == 'production' ? 'selected' : '' }}>
                                Production
                            </option>
                            <option value="staging" {{ old('environment') == 'staging' ? 'selected' : '' }}>
                                Staging
                            </option>
                            <option value="development" {{ old('environment') == 'development' ? 'selected' : '' }}>
                                Development
                            </option>
                        </select>
                        @error('environment')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="font-bold text-base mb-1" for="notes">Notes</label>
                        <textarea name="notes" 
                                  id="notes" 
                                  class="input-text @error('notes') border-red-500 @enderror" 
                                  rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <a href="{{ cp_route('hosting.servers.index') }}" class="btn mr-2">Cancel</a>
                <button type="submit" class="btn-primary">Create Server</button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const providerSelect = document.getElementById('provider');
            const descriptionDiv = document.getElementById('provider-description');

            function updateDescription() {
                const selectedOption = providerSelect.options[providerSelect.selectedIndex];
                const description = selectedOption.getAttribute('data-description');
                descriptionDiv.textContent = description || '';
            }

            providerSelect.addEventListener('change', updateDescription);
            updateDescription();
        });
    </script>
@endsection
