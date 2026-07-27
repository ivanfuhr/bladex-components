@php
    use Workbench\App\Playbook\PlaybookCode;

    $checked = (bool) ($state['checked'] ?? false);
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $tag = PlaybookCode::component('switch');

    echo PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'notifications'),
        PlaybookCode::boolean('checked', $checked),
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
    ])).PlaybookCode::closingTag($tag);
@endphp
