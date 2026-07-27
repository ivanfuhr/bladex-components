<?php

declare(strict_types=1);

namespace App\View\Components\Ui;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFactory;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;

final class Field extends Component
{
    public bool $fieldInvalid;

    public function __construct(
        public ?string $name = null,
        public bool $invalid = false,
        public string $orientation = 'block',
        public ?string $controlId = null,
    ) {
        $this->fieldInvalid = $invalid;

        if ($this->fieldInvalid || ! filled($name)) {
            return;
        }

        $errors = ViewFactory::shared('errors');

        if ($errors instanceof ViewErrorBag && $errors->has($name)) {
            $this->fieldInvalid = true;
        }
    }

    public function render(): View
    {
        return view('ui::field.wrapper');
    }
}
