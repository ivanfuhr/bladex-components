<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Workbench\App\Playbook\PlaybookPreviewRenderer;
use Workbench\App\Playbook\PlaybookRegistry;

final class PlaybookController
{
    public function __construct(
        private readonly PlaybookRegistry $registry,
        private readonly PlaybookPreviewRenderer $preview,
    ) {}

    public function index(): View
    {
        return view('workbench::playbook.index', [
            'categories' => $this->registry->grouped(),
        ]);
    }

    public function showcase(): View
    {
        return view('workbench::playbook.showcase');
    }

    public function show(string $component): View
    {
        if (! $this->registry->has($component)) {
            throw new NotFoundHttpException("Playbook component [{$component}] was not found.");
        }

        $playbook = $this->registry->get($component);
        $siblings = $this->registry->siblings($component);
        $mediaSlug = $this->registry->mediaSlug($component);

        return view('workbench::playbook.show', [
            'playbook' => $playbook,
            'initialPreview' => $this->preview->render($component),
            'initialSnippet' => $this->preview->renderSnippet($component),
            'previewUrl' => route('playbook.preview'),
            'mediaUrl' => $mediaSlug !== null ? route('playbook.media.show', $mediaSlug) : null,
            'previousPlaybook' => $siblings['previous'],
            'nextPlaybook' => $siblings['next'],
        ]);
    }
}
