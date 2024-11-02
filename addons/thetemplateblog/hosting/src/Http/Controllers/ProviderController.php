<?php

namespace Thetemplateblog\Hosting\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;
use Statamic\Facades\User;
use Illuminate\Support\Facades\Crypt;

class ProviderController extends CpController
{
    public function index()
    {
        $user = User::current();
        $providers = $user->get('providers', []);
        $availableProviders = collect(config('hosting.providers'));

        return view('hosting::providers.index', [
            'providers' => collect($providers),
            'availableProviders' => $availableProviders
        ]);
    }

    public function create()
    {
        $availableProviders = collect(config('hosting.providers'));

        return view('hosting::providers.create', [
            'availableProviders' => $availableProviders
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required',
            'provider_type' => 'required|in:'.implode(',', collect(config('hosting.providers'))->pluck('provider_type')->toArray()),
            'api_key' => 'required'
        ]);

        $user = User::current();
        $providers = $user->get('providers', []);
        
        $providers[] = [
            'label' => $validated['label'],
            'provider_type' => $validated['provider_type'],
            'api_key' => Crypt::encryptString($validated['api_key'])
        ];

        $user->set('providers', $providers);
        $user->save();

        return redirect()
            ->route('statamic.cp.hosting.providers.index')
            ->with('success', 'Provider added successfully');
    }

    public function edit($index)
    {
        $user = User::current();
        $providers = $user->get('providers', []);
        
        if (!isset($providers[$index])) {
            return redirect()->route('statamic.cp.hosting.providers.index')
                ->with('error', 'Provider not found');
        }

        $provider = $providers[$index];
        try {
            $provider['api_key'] = Crypt::decryptString($provider['api_key']);
        } catch (\Exception $e) {
            $provider['api_key'] = '';
        }

        $availableProviders = collect(config('hosting.providers'));

        return view('hosting::providers.edit', [
            'provider' => $provider,
            'index' => $index,
            'availableProviders' => $availableProviders
        ]);
    }

    public function update(Request $request, $index)
    {
        $validated = $request->validate([
            'label' => 'required',
            'provider_type' => 'required|in:'.implode(',', collect(config('hosting.providers'))->pluck('provider_type')->toArray()),
            'api_key' => 'required'
        ]);

        $user = User::current();
        $providers = $user->get('providers', []);

        if (!isset($providers[$index])) {
            return redirect()->route('statamic.cp.hosting.providers.index')
                ->with('error', 'Provider not found');
        }

        $providers[$index] = [
            'label' => $validated['label'],
            'provider_type' => $validated['provider_type'],
            'api_key' => Crypt::encryptString($validated['api_key'])
        ];

        $user->set('providers', $providers);
        $user->save();

        return redirect()
            ->route('statamic.cp.hosting.providers.index')
            ->with('success', 'Provider updated successfully');
    }

    public function destroy($index)
    {
        $user = User::current();
        $providers = $user->get('providers', []);

        if (!isset($providers[$index])) {
            return redirect()->route('statamic.cp.hosting.providers.index')
                ->with('error', 'Provider not found');
        }

        // Check if provider is in use
        $servers = $user->get('servers', []);
        $providerType = $providers[$index]['provider_type'];
        $inUse = collect($servers)->contains('provider', $providerType);

        if ($inUse) {
            return redirect()
                ->route('statamic.cp.hosting.providers.index')
                ->with('error', 'This provider cannot be deleted because it is being used by one or more servers.');
        }

        array_splice($providers, $index, 1);
        
        $user->set('providers', $providers);
        $user->save();

        return redirect()
            ->route('statamic.cp.hosting.providers.index')
            ->with('success', 'Provider deleted successfully');
    }
}
