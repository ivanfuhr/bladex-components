<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;

uses()->group('registry-isolated');

beforeEach(function () {
    config(['stencil.project_config_file' => 'stencil.json']);
    app()->forgetInstance(ProjectConfig::class);

    cleanupOwnedProjectArtifacts();
});

it('creates project config and lock via init', function () {
    $configPath = $this->app->basePath('stencil.json');
    $lockPath = $this->app->basePath('stencil.lock');

    expect(file_exists($configPath))->toBeFalse();

    $this->artisan('stencil:init')
        ->assertSuccessful();

    expect(file_exists($configPath))->toBeTrue();
    expect(file_exists($lockPath))->toBeTrue();
    expect(file_exists($this->app->basePath('resources/css/stencil.css')))->toBeTrue();

    $config = json_decode(file_get_contents($configPath), true);

    expect($config['paths']['ui'])->toBe('resources/views/ui');
    expect($config['paths']['icons'])->toBe('resources/views/ui/icons');
    expect($config['paths']['assets'])->toBe('resources/js/ui');
    expect($config['paths']['support'])->toBe('app/Support/Stencil');
    expect($config['registry'])->toBe(config('stencil.default_registry_url'));
    expect(file_exists($this->app->langPath('stencil-ui/en/messages.php')))->toBeTrue();
});

it('add installs registry items into resources/views/ui', function () {
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('stencil:add', ['names' => ['input']])
        ->assertSuccessful();

    $inputPath = $this->app->resourcePath('views/ui/input/index.blade.php');
    $groupPath = $this->app->resourcePath('views/ui/input/group/index.blade.php');
    $inputContents = file_get_contents($inputPath);

    expect(file_exists($inputPath))->toBeTrue();
    expect(file_exists($groupPath))->toBeTrue();
    expect($inputContents)->toContain('App\\Support\\Stencil');
    expect($inputContents)->not->toContain('Ivanfuhr\\Stencil');

    $lock = json_decode(file_get_contents($this->app->basePath('stencil.lock')), true);

    expect(collect($lock['items'])->pluck('name')->all())->toContain('input', 'input-group', 'field');
});

it('add textarea installs field dependencies including label', function () {
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('stencil:add', ['names' => ['textarea']])
        ->assertSuccessful();

    expect(file_exists($this->app->resourcePath('views/ui/textarea/index.blade.php')))->toBeTrue();

    $lock = json_decode(file_get_contents($this->app->basePath('stencil.lock')), true);

    expect(collect($lock['items'])->pluck('name')->all())->toContain('textarea', 'field', 'label', 'text');
});

it('add select installs owned javascript asset', function () {
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('stencil:add', ['names' => ['select']])
        ->assertSuccessful();

    $scriptPath = $this->app->resourcePath('views/ui/select/select.js');

    expect(file_exists($scriptPath))->toBeTrue();
});

it('add dialog installs owned javascript asset', function () {
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('stencil:add', ['names' => ['dialog']])
        ->assertSuccessful();

    $scriptPath = $this->app->resourcePath('views/ui/dialog/dialog.js');

    expect(file_exists($scriptPath))->toBeTrue();
});

it('renders owned select with translated strings from stencil-ui namespace', function () {
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('stencil:add', ['names' => ['select']])
        ->assertSuccessful();

    registerOwnedUiNamespace();

    $selectPath = $this->app->resourcePath('views/ui/select/index.blade.php');

    expect(file_get_contents($selectPath))->toContain('stencil-ui::messages');

    $html = Blade::render('<x-ui::select name="status" :multiple="true" display="chips" />');

    expect($html)
        ->toContain('data-select-chip-remove-label="Remove"')
        ->not->toContain('stencil-ui::messages')
        ->not->toContain('stencil::messages');
});

it('renders owned button loading state with the icon loading component', function () {
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('stencil:add', ['names' => ['button']])
        ->assertSuccessful();

    registerOwnedUiNamespace();

    expect(file_exists($this->app->resourcePath('views/ui/icon/loading.blade.php')))->toBeTrue();

    $html = Blade::render('<x-ui::button :loading="true">Save</x-ui::button>');

    expect($html)
        ->toContain('data-button-loading')
        ->toContain('data-button-loading-icon')
        ->toContain('animate-spin');
});

it('add select installs required lucide icon stubs', function () {
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('stencil:add', ['names' => ['select']])
        ->assertSuccessful();

    $iconsPath = $this->app->resourcePath('views/ui/icons');

    expect(file_exists($iconsPath.'/chevron-down.blade.php'))->toBeTrue();
    expect(file_exists($iconsPath.'/check.blade.php'))->toBeTrue();
    expect(file_exists($iconsPath.'/x.blade.php'))->toBeTrue();
});

it('fails add when project config is missing', function () {
    fakeRegistryHttp();

    $configPath = $this->app->basePath('stencil.json');

    if (file_exists($configPath)) {
        unlink($configPath);
    }

    $this->artisan('stencil:add', ['names' => ['input']])
        ->expectsOutputToContain('Project config not found')
        ->assertFailed();
});

it('renders owned ui input component after install', function () {
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('stencil:add', ['names' => ['input']])
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

    $this->artisan('stencil:add', ['names' => ['input']])
        ->assertSuccessful();

    $inputPath = $this->app->resourcePath('views/ui/input/index.blade.php');
    File::put($inputPath, '@owned marker');

    $this->artisan('stencil:update', ['--overwrite' => true])
        ->assertSuccessful();

    expect(file_get_contents($inputPath))->not->toBe('@owned marker');
});

it('removes installed registry items and files', function () {
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('stencil:add', ['names' => ['input']])
        ->assertSuccessful();

    $inputPath = $this->app->resourcePath('views/ui/input/index.blade.php');

    expect(file_exists($inputPath))->toBeTrue();

    $this->artisan('stencil:remove', ['names' => ['input-group']])
        ->assertSuccessful();

    expect(file_exists($this->app->resourcePath('views/ui/input/group/index.blade.php')))->toBeFalse();

    $lock = json_decode(file_get_contents($this->app->basePath('stencil.lock')), true);

    expect(collect($lock['items'])->pluck('name')->all())->toContain('input');
    expect(collect($lock['items'])->pluck('name')->all())->not->toContain('input-group');
});

it('lists registry items', function () {
    useOwnedRegistryProject();
    fakeRegistryHttp();

    $this->artisan('stencil:list')
        ->expectsOutputToContain('input')
        ->assertSuccessful();
});
