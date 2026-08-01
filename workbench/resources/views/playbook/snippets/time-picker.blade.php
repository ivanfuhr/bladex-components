@php
    use Workbench\App\Playbook\PlaybookCode;

    $withSeconds = (bool) ($state['withSeconds'] ?? false);
    $clearable = (bool) ($state['clearable'] ?? true);
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $value = $withSeconds ? '09:15:00' : '09:15';

    $tag = PlaybookCode::component('time-picker');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'doors_open'),
        PlaybookCode::attribute('value', $value),
        PlaybookCode::boolean('with-seconds', $withSeconds),
        PlaybookCode::boolean('clearable', $clearable, true),
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
    ]));

    echo $open."\n".PlaybookCode::closingTag($tag);
@endphp
