<?php

namespace Thetemplateblog\Hosting\Http\Controllers;

use Statamic\Http\Controllers\CP\CpController;

class HostingController extends CpController
{
    public function index()
    {
        return view('hosting::index');
    }
}
