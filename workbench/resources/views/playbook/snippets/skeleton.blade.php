@php
    use Workbench\App\Playbook\PlaybookCode;

    $rounded = ($state['rounded'] ?? 'default') === 'full' ? 'full' : null;
    $tag = PlaybookCode::component('skeleton');

    echo PlaybookCode::selfClosingTag($tag, array_filter([
        PlaybookCode::attribute('rounded', $rounded),
        PlaybookCode::attribute('class', 'h-4 w-48'),
    ]));
@endphp
