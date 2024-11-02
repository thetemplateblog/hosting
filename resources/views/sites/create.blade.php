@extends('statamic::layout')
@section('title', 'Add Site')

@section('content')
    <div class="flex items-center justify-between mb-3">
        <h1>Add Site</h1>
    </div>

    <form action="{{ cp_route('hosting.sites.store') }}" method="POST">
        @csrf

        <div class="card p-4">
            <!-- Site Name -->
            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="name">Site Name</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Give your site a name</p>
                </div>
                <input type="text" 
                       name="name" 
                       id="name" 
                       class="input-text" 
                       value="{{ old('name') }}" 
                       required>
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Domain Field -->
            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="domain">Domain</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Enter the domain name</p>
                </div>
                <input type="text" 
                       name="domain" 
                       id="domain" 
                       class="input-text" 
                       value="{{ old('domain') }}"
                       placeholder="example.com"
                       required>
                @error('domain')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Server Selection -->
            <div class="mb-4">
                <label class="font-bold text-base mb-1" for="server_index">Select Server</label>
                <div class="help-block -mt-1 mb-1">
                    <p>Select the server where this site will be hosted</p>
                </div>
                <select name="server_index" 
                        id="server_index" 
                        class="select-input" 
                        required>
                    <option value="">Select a server</option>
                    @foreach($servers as $index => $server)
                        <option value="{{ $index }}" 
                                {{ old('server_index') == $index ? 'selected' : '' }}>
                            {{ $server['name'] }}
                        </option>
                    @endforeach
                </select>
                @error('server_index')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end mt-4">
            <a href="{{ cp_route('hosting.sites.index') }}" class="btn mr-2">Cancel</a>
            <button type="submit" class="btn-primary">Create Site</button>
        </div>
    </form>
@endsection
