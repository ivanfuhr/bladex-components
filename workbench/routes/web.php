<?php

use Illuminate\Support\Facades\Route;
use Workbench\App\Http\Controllers\PlaybookController;
use Workbench\App\Http\Controllers\PlaybookMediaController;
use Workbench\App\Http\Controllers\PlaybookPreviewController;

Route::redirect('/', '/playbook');

Route::get('/playbook', [PlaybookController::class, 'index'])->name('playbook.index');

Route::get('/playbook/media/{component}', [PlaybookMediaController::class, 'show'])
    ->name('playbook.media.show')
    ->where('component', 'buttons|input|select|typography|icons|label|field|textarea|checkbox|radio|switch|dialog|combobox|file-upload|repeater|input-otp|slider');

Route::get('/playbook/{component}', [PlaybookController::class, 'show'])
    ->name('playbook.show')
    ->where('component', '[a-z0-9-]+');

Route::post('/playbook/preview', PlaybookPreviewController::class)
    ->name('playbook.preview');
