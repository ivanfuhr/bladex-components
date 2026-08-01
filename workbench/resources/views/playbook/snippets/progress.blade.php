@php
    use Workbench\App\Playbook\PlaybookCode;

    $indeterminate = (bool) ($state['indeterminate'] ?? false);
    $value = (int) ($state['value'] ?? 40);
    $size = ($state['size'] ?? 'default') === 'default' ? null : (string) $state['size'];
    $tag = PlaybookCode::component('progress');

    echo PlaybookCode::selfClosingTag($tag, array_filter([
        $indeterminate ? null : PlaybookCode::bound('value', $value),
        PlaybookCode::boolean('indeterminate', $indeterminate),
        PlaybookCode::attribute('size', $size),
    ]));
@endphp
