@php
    use Workbench\App\Playbook\PlaybookCode;

    $size = $state['size'] === 'default' ? null : (string) $state['size'];
    $variant = $state['variant'] === 'default' ? null : (string) $state['variant'];
    $color = $state['color'] === 'default' ? null : (string) $state['color'];
    $inline = (bool) ($state['inline'] ?? false);

    $tag = PlaybookCode::component('text');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::bound('size', $size),
        PlaybookCode::bound('variant', $variant),
        PlaybookCode::bound('color', $color),
        PlaybookCode::boolean('inline', $inline),
    ]));

    $code = $open."\n    Body copy with the configured size, variant, and color.\n".PlaybookCode::closingTag($tag);

    echo $code;
@endphp
