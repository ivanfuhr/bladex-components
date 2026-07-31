@php
    use Workbench\App\Playbook\PlaybookCode;

    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);

    $tag = PlaybookCode::component('color-picker');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'brand_color'),
        PlaybookCode::attribute('value', '#3366cc'),
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
        PlaybookCode::attribute('class', 'max-w-xs w-full'),
    ]));

    echo $open."\n".PlaybookCode::closingTag($tag);
@endphp
