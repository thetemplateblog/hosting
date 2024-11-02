<?php

namespace Thetemplateblog\Hosting\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;
use Statamic\Facades\User;
use Illuminate\Support\Facades\Log;

class ServerController extends CpController
{
    public function index()
    {
        $user = User::current();
        $providers = $user->get('providers', []);
        $servers = $user->get('servers', []);

        if (empty($providers)) {
            return redirect()->route('statamic.cp.hosting.providers.index')
                ->with('error', 'Please configure at least one provider before adding servers.');
        }

        return view('hosting::servers.index', [
            'servers' => collect($servers),
            'providers' => collect($providers)
        ]);
    }

    public function create()
    {
        $user = User::current();
        $providers = $user->get('providers', []);

        if (empty($providers)) {
            return redirect()->route('statamic.cp.hosting.providers.index')
                ->with('error', 'Please configure at least one provider before adding servers.');
        }

        return view('hosting::servers.create', [
            'providers' => collect($providers)
        ]);
    }

    public function store(Request $request)
    {
        $user = User::current();
        $providers = $user->get('providers', []);

        $validated = $request->validate([
            'name' => 'required',
            'provider' => 'required|in:'.implode(',', collect($providers)->pluck('provider_type')->toArray()),
            'username' => 'nullable',
            'environment' => 'required|in:production,staging,development',
            'notes' => 'nullable'
        ]);

        $servers = $user->get('servers', []);
        
        $servers[] = [
            'name' => $validated['name'],
            'provider' => $validated['provider'],
            'username' => $validated['username'] ?? 'root',
            'environment' => $validated['environment'],
            'notes' => $validated['notes'] ?? '',
            'status' => 'active'
        ];

        $user->set('servers', $servers);
        $user->save();

        return redirect()
            ->route('statamic.cp.hosting.servers.index')
            ->with('success', 'Server added successfully');
    }

    public function show($index)
    {
        $user = User::current();
        $servers = $user->get('servers', []);
        $providers = $user->get('providers', []);
        
        if (!isset($servers[$index])) {
            return redirect()->route('statamic.cp.hosting.servers.index')
                ->with('error', 'Server not found');
        }

        return view('hosting::servers.show', [
            'server' => $servers[$index],
            'index' => $index,
            'providers' => collect($providers)
        ]);
    }

    public function edit($index)
    {
        $user = User::current();
        $servers = $user->get('servers', []);
        $providers = $user->get('providers', []);
        
        if (!isset($servers[$index])) {
            return redirect()->route('statamic.cp.hosting.servers.index')
                ->with('error', 'Server not found');
        }

        return view('hosting::servers.edit', [
            'server' => $servers[$index],
            'index' => $index,
            'providers' => collect($providers)
        ]);
    }

    public function update(Request $request, $index)
    {
        $user = User::current();
        $providers = $user->get('providers', []);
        
        $validated = $request->validate([
            'name' => 'required',
            'provider' => 'required|in:'.implode(',', collect($providers)->pluck('provider_type')->toArray()),
            'username' => 'nullable',
            'environment' => 'required|in:production,staging,development',
            'notes' => 'nullable'
        ]);

        $servers = $user->get('servers', []);

        if (!isset($servers[$index])) {
            return redirect()->route('statamic.cp.hosting.servers.index')
                ->with('error', 'Server not found');
        }

        $servers[$index] = [
            'name' => $validated['name'],
            'provider' => $validated['provider'],
            'username' => $validated['username'] ?? 'root',
            'environment' => $validated['environment'],
            'notes' => $validated['notes'] ?? '',
            'status' => $servers[$index]['status'] ?? 'active'
        ];

        $user->set('servers', $servers);
        $user->save();

        return redirect()
            ->route('statamic.cp.hosting.servers.index')
            ->with('success', 'Server updated successfully');
    }

    public function destroy($index)
    {
        $user = User::current();
        $servers = $user->get('servers', []);

        if (!isset($servers[$index])) {
            return redirect()->route('statamic.cp.hosting.servers.index')
                ->with('error', 'Server not found');
        }

        array_splice($servers, $index, 1);
        
        $user->set('servers', $servers);
        $user->save();

        return redirect()
            ->route('statamic.cp.hosting.servers.index')
            ->with('success', 'Server deleted successfully');
    }
    public function deploySingle($index, Request $request)
    {
        $user = User::current();
        $servers = $user->get('servers', []);
    
        // Check if the server exists
        if (!isset($servers[$index])) {
            return redirect()
                ->route('statamic.cp.hosting.servers.index')  // Update here!
                ->with('error', 'Server not found.');
        }
    
        // Simulating deployment logic
        $server = $servers[$index];
        \Log::info('Deploying server: ' . $server['name']);
    
        return redirect()  
            ->route('statamic.cp.hosting.servers.index') // Ensure the correct route here!
            ->with('success', 'Server "' . $server['name'] . '" deployed successfully.');
    }

}
