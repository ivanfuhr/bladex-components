@php
    use Workbench\App\Playbook\PlaybookCode;

    $type = ($state['type'] ?? 'single') === 'multiple' ? 'multiple' : 'single';
    $variant = ($state['variant'] ?? 'outline') === 'default' ? null : 'outline';
    $size = ($state['size'] ?? 'default') === 'default' ? null : (string) $state['size'];
    $orientation = ($state['orientation'] ?? 'horizontal') === 'vertical' ? 'vertical' : null;
    $spacing = (int) ($state['spacing'] ?? 0);

    $group = PlaybookCode::component('toggle-group');
    $item = PlaybookCode::component('toggle-group.item');

    $open = PlaybookCode::openingTag($group, array_filter([
        PlaybookCode::attribute('type', $type === 'single' ? null : $type),
        PlaybookCode::attribute('variant', $variant),
        PlaybookCode::attribute('size', $size),
        PlaybookCode::attribute('orientation', $orientation),
        $spacing > 0 ? PlaybookCode::attribute('spacing', (string) $spacing) : null,
        PlaybookCode::attribute('default-value', $type === 'multiple' ? null : 'bold'),
        $type === 'multiple' ? ':default-value="[\'bold\', \'italic\']"' : null,
        'aria-label="Text formatting"',
    ]));

    $items = implode("\n", [
        PlaybookCode::openingTag($item, [PlaybookCode::attribute('value', 'bold')]).'Bold'.PlaybookCode::closingTag($item),
        PlaybookCode::openingTag($item, [PlaybookCode::attribute('value', 'italic')]).'Italic'.PlaybookCode::closingTag($item),
        PlaybookCode::openingTag($item, [PlaybookCode::attribute('value', 'underline')]).'Underline'.PlaybookCode::closingTag($item),
    ]);

    echo $open."\n".$items."\n".PlaybookCode::closingTag($group);
@endphp
