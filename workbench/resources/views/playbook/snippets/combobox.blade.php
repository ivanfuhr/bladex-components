@php
    use Workbench\App\Playbook\PlaybookCode;

    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $placeholder = (string) ($state['placeholder'] ?? 'Search frameworks…');

    $tag = PlaybookCode::component('combobox');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'framework'),
        PlaybookCode::attribute('placeholder', $placeholder),
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
        PlaybookCode::attribute('size', $size),
        PlaybookCode::attribute('class', 'max-w-md w-full'),
    ]));

    $g = PlaybookCode::component('combobox.group');
    $l = PlaybookCode::component('combobox.label');
    $i = PlaybookCode::component('combobox.item');
    $s = PlaybookCode::component('combobox.separator');

    $body = <<<BLADE
        <{$g}>
            <{$l}>PHP</{$l}>
            <{$i} value="laravel">Laravel</{$i}>
            <{$i} value="symfony">Symfony</{$i}>
        </{$g}>
        <{$s} />
        <{$g}>
            <{$l}>JavaScript</{$l}>
            <{$i} value="react">React</{$i}>
            <{$i} value="vue">Vue</{$i}>
            <{$i} value="svelte">Svelte</{$i}>
        </{$g}>
        <{$s} />
        <{$i} value="rails">Ruby on Rails</{$i}>
        <{$i} value="django">Django</{$i}>

    BLADE;

    $code = $open."\n".$body.PlaybookCode::closingTag($tag);

    echo $code;
@endphp
