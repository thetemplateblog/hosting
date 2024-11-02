<?php

namespace Thetemplateblog\Hosting\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;
use Statamic\Facades\User;

class ServerController extends CpController
{
    public function index()
    {
        $user = User::current();
        $servers = $user->get('servers', []);

        return view('hosting::servers.index', [
            'servers' => collect($servers)
        ]);
    }

    public function create()
    {
        return view('hosting::servers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'provider' => 'required|in:'.implode(',', collect(config('hosting.providers'))->pluck('provider_type')->toArray()),
            'username' => 'nullable',
            'environment' => 'required|in:production,staging,development',
            'notes' => 'nullable'
        ]);

        $user = User::current();
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
        
        if (!isset($servers[$index])) {
            return redirect()->route('statamic.cp.hosting.servers.index')
                ->with('error', 'Server not found');
        }

        return view('hosting::servers.show', [
            'server' => $servers[$index],
            'index' => $index
        ]);
    }

    public function edit($index)
    {
        $user = User::current();
        $servers = $user->get('servers', []);
        
        if (!isset($servers[$index])) {
            return redirect()->route('statamic.cp.hosting.servers.index')
                ->with('error', 'Server not found');
        }

        return view('hosting::servers.edit', [
            'server' => $servers[$index],
            'index' => $index
        ]);
    }

    public function update(Request $request, $index)
    {
        $validated = $request->validate([
            'name' => 'required',
            'provider' => 'required|in:'.implode(',', collect(config('hosting.providers'))->pluck('provider_type')->toArray()),
            'username' => 'nullable',
            'environment' => 'required|in:production,staging,development',
            'notes' => 'nullable'
        ]);

        $user = User::current();
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
}
