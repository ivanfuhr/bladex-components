@php
    use Workbench\App\Playbook\PlaybookCode;

    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $min = max(0, (int) ($state['min'] ?? 1));
    $max = filled($state['max'] ?? null) ? max($min, (int) $state['max']) : null;

    $tag = PlaybookCode::component('repeater');
    $itemTag = PlaybookCode::component('repeater.item');
    $addTag = PlaybookCode::component('repeater.add');
    $removeTag = PlaybookCode::component('repeater.remove');
    $inputTag = PlaybookCode::component('input');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'members'),
        ':value="[[\'name\' => \'Ada Lovelace\', \'role\' => \'Owner\'], [\'name\' => \'Alan Turing\', \'role\' => \'Member\']]"',
        PlaybookCode::bound('min', $min, 0),
        filled($max) ? PlaybookCode::bound('max', $max) : null,
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
        PlaybookCode::attribute('class', 'max-w-xl w-full'),
    ]));

    $nameInput = PlaybookCode::openingTag($inputTag, array_filter([
        PlaybookCode::attribute('data-repeater-field', 'name'),
        PlaybookCode::attribute('placeholder', 'Name'),
    ])).PlaybookCode::closingTag($inputTag);

    $roleInput = PlaybookCode::openingTag($inputTag, array_filter([
        PlaybookCode::attribute('data-repeater-field', 'role'),
        PlaybookCode::attribute('placeholder', 'Role'),
    ])).PlaybookCode::closingTag($inputTag);

    $code = $open."\n";
    $code .= '    '.PlaybookCode::openingTag($itemTag, [])."\n";
    $code .= '        <div class="grid gap-3 sm:grid-cols-2">'."\n";
    $code .= '            '.$nameInput."\n";
    $code .= '            '.$roleInput."\n";
    $code .= "        </div>\n";
    $code .= '        '.PlaybookCode::openingTag($removeTag, []).PlaybookCode::closingTag($removeTag)."\n";
    $code .= '    '.PlaybookCode::closingTag($itemTag)."\n\n";
    $code .= '    '.PlaybookCode::openingTag($addTag, []).'Add member'.PlaybookCode::closingTag($addTag)."\n";
    $code .= PlaybookCode::closingTag($tag);

    echo $code;
@endphp
