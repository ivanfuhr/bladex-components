@php
    use Workbench\App\Playbook\PlaybookCode;

    $type = (string) ($state['type'] ?? 'always');
    $horizontal = (bool) ($state['horizontal'] ?? false);

    $scrollArea = PlaybookCode::component('scroll-area');

    $code = PlaybookCode::openingTag($scrollArea, array_filter([
        'class="h-56 w-48 rounded-md border"',
        PlaybookCode::attribute('type', $type, 'hover'),
        PlaybookCode::boolean('horizontal', $horizontal, false),
        'aria-label="Tags"',
    ]))."\n";
    $code .= "    <div class=\"p-4\">…</div>\n";
    $code .= PlaybookCode::closingTag($scrollArea);

    echo $code;
@endphp
