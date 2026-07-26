<?php

use Illuminate\Support\Facades\Route;
use Workbench\App\Http\Controllers\PlaybookController;
use Workbench\App\Http\Controllers\PlaybookPreviewController;

Route::redirect('/', '/playbook');

Route::get('/playbook', [PlaybookController::class, 'index'])->name('playbook.index');

Route::get('/playbook/{component}', [PlaybookController::class, 'show'])
    ->name('playbook.show')
    ->where('component', '[a-z]+');

Route::post('/playbook/preview', PlaybookPreviewController::class)
    ->name('playbook.preview');
