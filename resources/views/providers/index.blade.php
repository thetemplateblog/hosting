@extends('statamic::layout')
@section('title', 'Providers')

@section('content')
    <div class="flex items-center justify-between mb-3">
        <h1>Providers</h1>
        <a href="{{ cp_route('hosting.providers.create') }}" class="btn-primary">Add Provider</a>
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

    <div class="card p-0">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Provider</th>
                    <th class="actions-column"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($providers as $index => $provider)
                <tr>
                    <td>{{ $provider['label'] }}</td>
                    <td>
                        @php
                            $providerConfig = $availableProviders->firstWhere('provider_type', $provider['provider_type']);
                        @endphp
                        {{ $providerConfig['label'] ?? ucfirst($provider['provider_type']) }}
                    </td>
                    <td class="flex justify-end">
                            <div class="btn-group">
                                <a href="{{ cp_route('hosting.providers.edit', ['index' => $index]) }}" class="btn btn-small">Edit</a>
                                <form 
                                    method="POST" 
                                    action="{{ cp_route('hosting.providers.destroy', ['index' => $index]) }}" 
                                    class="inline"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit"
                                        class="btn btn-small"
                                        onclick="return confirm('Are you sure you want to delete this provider?')"
                                    >Delete</button>
                                </form>
                            </div>
                        </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center p-3">No providers configured</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
