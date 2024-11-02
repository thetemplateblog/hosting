<?php

namespace TheTemplateBlog\Hosting\Http\Controllers;

use Statamic\Http\Controllers\CP\CpController;
use Statamic\Facades\Entry;

class HostingController extends CpController
{
    public function index()
    {
        $servers = Entry::query()
            ->where('collection', 'servers')
            ->orderBy('title')
            ->get();

        return view('hosting::index', [
            'servers' => $servers
        ]);
    }
}
