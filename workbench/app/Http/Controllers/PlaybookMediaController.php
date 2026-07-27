<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class PlaybookMediaController
{
    public function buttons(Request $request): View
    {
        return view('workbench::playbook.media.buttons', [
            'dark' => $request->boolean('dark'),
        ]);
    }

    public function overview(Request $request): View
    {
        return view('workbench::playbook.media.overview', [
            'dark' => $request->boolean('dark'),
        ]);
    }
}
