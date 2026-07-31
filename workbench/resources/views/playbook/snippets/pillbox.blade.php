@php
    use Workbench\App\Playbook\PlaybookCode;

    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $max = filled($state['max'] ?? null) ? max(1, (int) $state['max']) : null;

    $tag = PlaybookCode::component('pillbox');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'tags'),
        ':value="[\'laravel\', \'php\', \'blade\']"',
        filled($max) ? PlaybookCode::bound('max', $max) : null,
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
        PlaybookCode::attribute('placeholder', 'Add tags…'),
        PlaybookCode::attribute('class', 'max-w-xl w-full'),
    ]));

    echo $open."\n".PlaybookCode::closingTag($tag);
@endphp
