@php
    use Workbench\App\Playbook\PlaybookCode;

    $variant = ($state['variant'] ?? 'default') === 'outline' ? 'outline' : null;
    $size = ($state['size'] ?? 'default') === 'default' ? null : (string) $state['size'];
    $pressed = (bool) ($state['pressed'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $tag = PlaybookCode::component('toggle');

    echo PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('variant', $variant),
        PlaybookCode::attribute('size', $size),
        PlaybookCode::boolean('pressed', $pressed),
        PlaybookCode::boolean('disabled', $disabled),
        'aria-label="Toggle italic"',
    ])).'Italic'.PlaybookCode::closingTag($tag);
@endphp
