@php
    use Workbench\App\Playbook\PlaybookCode;

    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $tag = PlaybookCode::component('textarea');

    echo PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'bio'),
        PlaybookCode::attribute('placeholder', 'Tell us about yourself…'),
        PlaybookCode::attribute('rows', '4'),
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
    ])).PlaybookCode::closingTag($tag);
@endphp
