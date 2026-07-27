<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;

uses()->group('registry-isolated');

beforeEach(function () {
    cleanupOwnedProjectArtifacts();
});

it('creates project config and lock via init', function () {
    $configPath = $this->app->basePath('bladex-components.json');
    $lockPath = $this->app->basePath('bladex-components.lock');

    expect(file_exists($configPath))->toBeFalse();

    $this->artisan('bladex-components:init')
        ->assertSuccessful();

    expect(file_exists($configPath))->toBeTrue();
    expect(file_exists($lockPath))->toBeTrue();
    expect(file_exists($this->app->basePath('resources/css/bladex.css')))->toBeTrue();

    $config = json_decode(file_get_contents($configPath), true);

    expect($config['paths']['ui'])->toBe('resources/views/ui');
    expect($config['paths']['icons'])->toBe('resources/views/ui/icons');
    expect($config['paths']['assets'])->toBe('resources/js/ui');
    expect($config['paths']['support'])->toBe('app/Support/Bladex');
    expect($config['registry'])->toBe(config('bladex-components.default_registry_url'));
});

it('add installs registry items into resources/views/ui', function () {
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('bladex-components:add', ['names' => ['input']])
        ->assertSuccessful();

    $inputPath = $this->app->resourcePath('views/ui/input/index.blade.php');
    $groupPath = $this->app->resourcePath('views/ui/input/group/index.blade.php');
    $inputContents = file_get_contents($inputPath);

    expect(file_exists($inputPath))->toBeTrue();
    expect(file_exists($groupPath))->toBeTrue();
    expect($inputContents)->toContain('App\\Support\\Bladex');
    expect($inputContents)->not->toContain('Ivanfuhr\\BladexComponents');

    $lock = json_decode(file_get_contents($this->app->basePath('bladex-components.lock')), true);

    expect(collect($lock['items'])->pluck('name')->all())->toContain('input', 'input-group', 'field');
});

it('add select installs owned javascript asset', function () {
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('bladex-components:add', ['names' => ['select']])
        ->assertSuccessful();

    $scriptPath = $this->app->resourcePath('views/ui/select/select.js');

    expect(file_exists($scriptPath))->toBeTrue();
});

it('renders owned button loading state without the icon loading component', function () {
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('bladex-components:add', ['names' => ['button']])
        ->assertSuccessful();

    registerOwnedUiNamespace();

    expect(file_exists($this->app->resourcePath('views/ui/icon/loading.blade.php')))->toBeFalse();

    $html = Blade::render('<x-ui::button :loading="true">Save</x-ui::button>');

    expect($html)
        ->toContain('data-button-loading')
        ->toContain('data-button-loading-icon')
        ->toContain('animate-spin')
        ->not->toContain('icon.loading');
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
    useOwnedRegistryProject();
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
    useOwnedRegistryProject();
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
    useOwnedRegistryProject();
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
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('bladex-components:list')
        ->expectsOutputToContain('input')
        ->assertSuccessful();
});
