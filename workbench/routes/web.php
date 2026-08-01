<?php

use Illuminate\Support\Facades\Route;
use Workbench\App\Http\Controllers\PlaybookController;
use Workbench\App\Http\Controllers\PlaybookMediaController;
use Workbench\App\Http\Controllers\PlaybookPreviewController;

Route::redirect('/', '/playbook');

Route::get('/playbook', [PlaybookController::class, 'index'])->name('playbook.index');

Route::get('/playbook/showcase', [PlaybookController::class, 'showcase'])->name('playbook.showcase');

Route::redirect('/playbook/media/buttons', '/playbook/media/button');

Route::get('/playbook/media/{component}', [PlaybookMediaController::class, 'show'])
    ->name('playbook.media.show')
    ->where(
        'component',
        'button|input|input-currency|select|typography|icons|label|field|textarea|checkbox|radio|switch|dialog|calendar|date-picker|time-picker|datetime-picker|combobox|file-upload|repeater|pillbox|rating|color-picker|input-otp|slider|accordion|collapsible|avatar|badge|breadcrumb|card|dropdown-menu|popover|separator|skeleton|tabs|tooltip|toast|progress|alert|table|pagination',
    );

Route::get('/playbook/{component}', [PlaybookController::class, 'show'])
    ->name('playbook.show')
    ->where('component', '[a-z0-9-]+');

Route::post('/playbook/preview', PlaybookPreviewController::class)
    ->name('playbook.preview');
