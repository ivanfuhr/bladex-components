<?php

use Illuminate\Support\Facades\Route;
use Workbench\App\Http\Controllers\PlaybookController;
use Workbench\App\Http\Controllers\PlaybookMediaController;
use Workbench\App\Http\Controllers\PlaybookPreviewController;

Route::redirect('/', '/playbook');

Route::get('/playbook', [PlaybookController::class, 'index'])->name('playbook.index');

Route::get('/playbook/media/buttons', [PlaybookMediaController::class, 'buttons'])->name('playbook.media.buttons');
Route::get('/playbook/media/overview', [PlaybookMediaController::class, 'overview'])->name('playbook.media.overview');

Route::get('/playbook/{component}', [PlaybookController::class, 'show'])
    ->name('playbook.show')
    ->where('component', '[a-z]+');

Route::post('/playbook/preview', PlaybookPreviewController::class)
    ->name('playbook.preview');
