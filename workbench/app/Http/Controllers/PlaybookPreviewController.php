<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Workbench\App\Playbook\PlaybookPreviewRenderer;
use Workbench\App\Playbook\PlaybookRegistry;

final class PlaybookPreviewController
{
    public function __construct(
        private readonly PlaybookRegistry $registry,
        private readonly PlaybookPreviewRenderer $preview,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'component' => ['required', 'string', 'alpha_dash'],
            'state' => ['nullable', 'array'],
        ]);

        $slug = (string) $payload['component'];

        if (! $this->registry->has($slug)) {
            throw new NotFoundHttpException("Playbook component [{$slug}] was not found.");
        }

        try {
            $state = (array) ($payload['state'] ?? []);
            $html = $this->preview->render($slug, $state);
            $snippet = $this->preview->renderSnippet($slug, $state);
        } catch (ValidationException $exception) {
            throw $exception;
        }

        return response()->json([
            'html' => $html,
            'snippet' => $snippet,
        ]);
    }
}
