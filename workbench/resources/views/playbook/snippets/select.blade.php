@php
    use Workbench\App\Playbook\PlaybookCode;

    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $placeholder = (string) ($state['placeholder'] ?? 'Choose industry…');

    $tag = PlaybookCode::component('select');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'industry'),
        PlaybookCode::attribute('placeholder', $placeholder),
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
        PlaybookCode::attribute('size', $size),
        PlaybookCode::attribute('class', 'max-w-md w-full'),
    ]));

    $g = PlaybookCode::component('select.group');
    $l = PlaybookCode::component('select.label');
    $i = PlaybookCode::component('select.item');
    $s = PlaybookCode::component('select.separator');

    $body = <<<BLADE
    <{$g}>
        <{$l}>Creative</{$l}>
        <{$i} value="photo">Photography</{$i}>
        <{$i} value="design">Design services</{$i}>
    </{$g}>
    <{$s} />
    <{$i} value="web">Web development</{$i}>
    <{$i} value="accounting">Accounting</{$i}>
    <{$i} value="other">Other</{$i}>

BLADE;

    $code = $open."\n".$body.PlaybookCode::closingTag($tag);

    echo $code;
@endphp
