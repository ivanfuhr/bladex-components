<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PlaybookMediaController
{
    /** @var list<string> */
    private const array COMPONENTS = [
        'buttons',
        'input',
        'select',
        'typography',
        'icons',
        'label',
        'field',
        'textarea',
        'checkbox',
        'radio',
        'switch',
        'dialog',
        'combobox',
        'file-upload',
        'repeater',
        'pillbox',
        'rating',
        'color-picker',
        'input-otp',
        'slider',
    ];

    public function __construct(
        private readonly ViewFactory $views,
    ) {}

    public function show(Request $request, string $component): View
    {
        if (! in_array($component, self::COMPONENTS, true)) {
            throw new NotFoundHttpException("Media component [{$component}] was not found.");
        }

        $view = 'workbench::playbook.media.'.$component;

        if (! $this->views->exists($view)) {
            throw new NotFoundHttpException("Media view [{$component}] was not found.");
        }

        return $this->views->make($view, [
            'dark' => $request->boolean('dark'),
        ]);
    }
}
