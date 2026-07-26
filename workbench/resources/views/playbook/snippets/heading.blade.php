@php
    use Workbench\App\Playbook\PlaybookCode;

    $level = (int) $state['level'];
    $variant = $state['variant'] === 'default' ? null : (string) $state['variant'];

    $tag = PlaybookCode::component('heading');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::bound('level', $level),
        PlaybookCode::bound('variant', $variant),
    ]));

    $code = $open."\n    Page title at level {$level}\n".PlaybookCode::closingTag($tag);

    echo $code;
@endphp
