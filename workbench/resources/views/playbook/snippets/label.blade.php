@php
    use Workbench\App\Playbook\PlaybookCode;

    $badge = $state['badge'] ?? '';
    $required = (bool) ($state['required'] ?? false);
    $tag = PlaybookCode::component('label');

    echo PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('for', 'email'),
        $badge !== '' ? PlaybookCode::attribute('badge', $badge) : null,
        PlaybookCode::boolean('required', $required),
    ])).'Email address'.PlaybookCode::closingTag($tag);
@endphp
