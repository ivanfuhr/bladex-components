<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $paths = [
        app()->basePath('bladex-components.json'),
        app()->basePath('bladex-components.lock'),
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    File::deleteDirectory(app()->resourcePath('views/ui'));
});

it('creates project config and lock via init', function () {
    $configPath = $this->app->basePath('bladex-components.json');
    $lockPath = $this->app->basePath('bladex-components.lock');

    expect(file_exists($configPath))->toBeFalse();

    $this->artisan('bladex-components:init')
        ->assertSuccessful();

    expect(file_exists($configPath))->toBeTrue();
    expect(file_exists($lockPath))->toBeTrue();

    $config = json_decode(file_get_contents($configPath), true);

    expect($config['paths']['ui'])->toBe('resources/views/ui');
    expect($config['paths']['icons'])->toBe('resources/views/ui/icons');
    expect($config['registry'])->toBe(config('bladex-components.default_registry_url'));
});

it('add installs registry items into resources/views/ui', function () {
    useRegistryProjectConfig();
    fakeRegistryHttp();

    $this->artisan('bladex-components:add', ['names' => ['input']])
        ->assertSuccessful();

    $inputPath = $this->app->resourcePath('views/ui/input/index.blade.php');
    $groupPath = $this->app->resourcePath('views/ui/input/group/index.blade.php');

    expect(file_exists($inputPath))->toBeTrue();
    expect(file_exists($groupPath))->toBeTrue();

    $lock = json_decode(file_get_contents($this->app->basePath('bladex-components.lock')), true);

    expect(collect($lock['items'])->pluck('name')->all())->toContain('input', 'input-group');
});

it('fails add when project config is missing', function () {
    fakeRegistryHttp();

    $configPath = $this->app->basePath('bladex-components.json');

    if (file_exists($configPath)) {
        unlink($configPath);
    }

    $this->artisan('bladex-components:add', ['names' => ['input']])
        ->expectsOutputToContain('Project config not found')
        ->assertFailed();
});

it('renders owned ui input component after install', function () {
    useRegistryProjectConfig();
    fakeRegistryHttp();

    $this->artisan('bladex-components:add', ['names' => ['input']])
        ->assertSuccessful();

    registerOwnedUiNamespace();
    Artisan::call('view:clear');

    $html = Blade::render('<x-ui::input name="email" />');

    expect($html)->toContain('data-input-control');
    expect($html)->toContain('name="email"');
});

it('updates installed files from the registry', function () {
    useRegistryProjectConfig();
    fakeRegistryHttp();

    $this->artisan('bladex-components:add', ['names' => ['input']])
        ->assertSuccessful();

    $inputPath = $this->app->resourcePath('views/ui/input/index.blade.php');
    File::put($inputPath, '@owned marker');

    $this->artisan('bladex-components:update', ['--overwrite' => true])
        ->assertSuccessful();

    expect(file_get_contents($inputPath))->not->toBe('@owned marker');
});

it('removes installed registry items and files', function () {
    useRegistryProjectConfig();
    fakeRegistryHttp();

    $this->artisan('bladex-components:add', ['names' => ['input']])
        ->assertSuccessful();

    $inputPath = $this->app->resourcePath('views/ui/input/index.blade.php');

    expect(file_exists($inputPath))->toBeTrue();

    $this->artisan('bladex-components:remove', ['names' => ['input-group']])
        ->assertSuccessful();

    expect(file_exists($this->app->resourcePath('views/ui/input/group/index.blade.php')))->toBeFalse();

    $lock = json_decode(file_get_contents($this->app->basePath('bladex-components.lock')), true);

    expect(collect($lock['items'])->pluck('name')->all())->toContain('input');
    expect(collect($lock['items'])->pluck('name')->all())->not->toContain('input-group');
});

it('lists registry items', function () {
    useRegistryProjectConfig();
    fakeRegistryHttp();

    $this->artisan('bladex-components:list')
        ->expectsOutputToContain('input')
        ->assertSuccessful();
});
