@extends('statamic::layout')
@section('title', 'Add Provider')

@section('content')
    <div class="flex items-center justify-between mb-3">
        <h1>Add Provider</h1>
    </div>

    <form action="{{ cp_route('hosting.providers.store') }}" method="POST">
        @csrf
        
        <div class="card p-4">
            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="label">Label</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Give this provider configuration a name</p>
                </div>
                <input type="text" 
                       name="label" 
                       id="label" 
                       class="input-text" 
                       value="{{ old('label') }}" 
                       required>
                @error('label')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="provider_type">Provider</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Select the hosting provider</p>
                </div>
                <select name="provider_type" 
                        id="provider_type" 
                        class="select-input" 
                        required>
                    <option value="">Select a provider</option>
                    @foreach($availableProviders as $provider)
                        <option value="{{ $provider['provider_type'] }}" 
                                {{ old('provider_type') == $provider['provider_type'] ? 'selected' : '' }}
                                data-description="{{ $provider['description'] }}">
                            {{ $provider['label'] }}
                        </option>
                    @endforeach
                </select>
                <div id="provider-description" class="text-sm text-gray-500 mt-1"></div>
                @error('provider_type')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="api_key">API Key</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Enter your provider API key</p>
                </div>
                <input type="password" 
                       name="api_key" 
                       id="api_key" 
                       class="input-text" 
                       required>
                @error('api_key')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <a href="{{ cp_route('hosting.providers.index') }}" class="btn mr-2">Cancel</a>
            <button type="submit" class="btn-primary">Create Provider</button>
        </div>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('provider_type');
            const description = document.getElementById('provider-description');

            function updateDescription() {
                const selected = select.options[select.selectedIndex];
                description.textContent = selected.dataset.description || '';
            }

            select.addEventListener('change', updateDescription);
            updateDescription();
        });
    </script>
    @endpush
@endsection
