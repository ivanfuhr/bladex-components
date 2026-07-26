<?php

declare(strict_types=1);

namespace Workbench\App\Playbook;

use Illuminate\Contracts\View\Factory as ViewFactory;

final class PlaybookPreviewRenderer
{
    public function __construct(
        private readonly PlaybookRegistry $registry,
        private readonly PlaybookStateValidator $validator,
        private readonly ViewFactory $views,
    ) {}

    /**
     * @param  array<string, mixed>  $state
     */
    public function render(string $slug, array $state = []): string
    {
        $playbook = $this->registry->get($slug);

        if ($state === []) {
            $state = $playbook->defaultState;
        }

        $validated = $this->validator->validate($playbook, $state);

        return $this->views
            ->make($playbook->previewView, ['state' => $validated])
            ->render();
    }

    /**
     * @param  array<string, mixed>  $state
     */
    public function renderSnippet(string $slug, array $state = []): string
    {
        $playbook = $this->registry->get($slug);
        $view = 'workbench::playbook.snippets.'.$slug;

        if (! $this->views->exists($view)) {
            return '';
        }

        if ($state === []) {
            $state = $playbook->defaultState;
        }

        $validated = $this->validator->validate($playbook, $state);

        return trim($this->views->make($view, ['state' => $validated])->render());
    }
}
