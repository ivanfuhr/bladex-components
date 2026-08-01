@php
    use Workbench\App\Playbook\PlaybookCode;

    $sizeClass = match ($state['size'] ?? 'outline') {
        'micro' => 'size-3',
        'mini' => 'size-5',
        default => 'size-4',
    };

    $tag = PlaybookCode::component('icon');

    echo PlaybookCode::selfClosingTag($tag, [
        PlaybookCode::attribute('name', 'check'),
        PlaybookCode::attribute('class', $sizeClass),
    ]);
@endphp
