<?php

namespace Thetemplateblog\Hosting\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;
use Statamic\Facades\User;
use Illuminate\Support\Facades\Log;

class SiteController extends CpController
{
    public function index()
    {
        $user = User::current();
        $servers = $user->get('servers', []);
        $sites = $user->get('sites', []);

        if (empty($servers)) {
            return redirect()->route('statamic.cp.hosting.servers.index')
                ->with('error', 'Please configure at least one server before adding sites.');
        }

        return view('hosting::sites.index', [
            'sites' => collect($sites),
            'servers' => collect($servers)
        ]);
    }

    public function create()
    {
        $user = User::current();
        $servers = $user->get('servers', []);

        if (empty($servers)) {
            return redirect()->route('statamic.cp.hosting.servers.index')
                ->with('error', 'Please configure at least one server before adding sites.');
        }

        return view('hosting::sites.create', [
            'servers' => collect($servers)
        ]);
    }

    public function store(Request $request)
    {
        $user = User::current();
        $servers = $user->get('servers', []);

        $validated = $request->validate([
            'name' => 'required',
            'domain' => 'required',
            'server_index' => 'required|integer|min:0|max:' . (count($servers) - 1),
        ]);

        $sites = $user->get('sites', []);
        
        $sites[] = [
            'name' => $validated['name'],
            'domain' => $validated['domain'],
            'server_index' => $validated['server_index'],
            'status' => 'active'
        ];

        $user->set('sites', $sites);
        $user->save();

        return redirect()
            ->route('statamic.cp.hosting.sites.index')
            ->with('success', 'Site added successfully');
    }

    public function edit($index)
    {
        $user = User::current();
        $sites = $user->get('sites', []);
        $servers = $user->get('servers', []);
        
        if (!isset($sites[$index])) {
            return redirect()->route('statamic.cp.hosting.sites.index')
                ->with('error', 'Site not found');
        }

        return view('hosting::sites.edit', [
            'site' => $sites[$index],
            'index' => $index,
            'servers' => collect($servers)
        ]);
    }

    public function update(Request $request, $index)
    {
        $user = User::current();
        $servers = $user->get('servers', []);
        
        $validated = $request->validate([
            'name' => 'required',
            'domain' => 'required',
            'server_index' => 'required|integer|min:0|max:' . (count($servers) - 1),
        ]);

        $sites = $user->get('sites', []);

        if (!isset($sites[$index])) {
            return redirect()->route('statamic.cp.hosting.sites.index')
                ->with('error', 'Site not found');
        }

        $sites[$index] = [
            'name' => $validated['name'],
            'domain' => $validated['domain'],
            'server_index' => $validated['server_index'],
            'status' => $sites[$index]['status'] ?? 'active'
        ];

        $user->set('sites', $sites);
        $user->save();

        return redirect()
            ->route('statamic.cp.hosting.sites.index')
            ->with('success', 'Site updated successfully');
    }

    public function destroy($index)
    {
        $user = User::current();
        $sites = $user->get('sites', []);

        if (!isset($sites[$index])) {
            return redirect()->route('statamic.cp.hosting.sites.index')
                ->with('error', 'Site not found');
        }

        array_splice($sites, $index, 1);
        
        $user->set('sites', $sites);
        $user->save();

        return redirect()
            ->route('statamic.cp.hosting.sites.index')
            ->with('success', 'Site deleted successfully');
    }
    public function deploySingle($index, Request $request)
    {
        $user = User::current();
        $sites = $user->get('sites', []);

        // Check if the site exists
        if (!isset($sites[$index])) {
            return redirect()->route('statamic.cp.hosting.sites.index')
                ->with('error', 'Site not found.');
        }

        // Simulate deployment logic for the site
        $site = $sites[$index];
        Log::info('Deploying site: ' . $site['name'] . ' (Domain: ' . $site['domain'] . ')');

        return redirect()->route('statamic.cp.hosting.sites.index')
            ->with('success', 'Site "' . $site['name'] . '" deployed successfully.');
    }
}
