@php
    use Workbench\App\Playbook\PlaybookCode;

    $language = (string) ($state['language'] ?? 'blade');
    $showCopy = (bool) ($state['show_copy'] ?? true);

    $buttonGroup = PlaybookCode::component('button-group');
    $button = PlaybookCode::component('button');

    $sample = PlaybookCode::openingTag($buttonGroup, [
        PlaybookCode::attribute('aria-label', 'Document actions'),
    ])."\n";
    $sample .= '    '.PlaybookCode::openingTag($button, [
        PlaybookCode::attribute('variant', 'outline'),
    ]).'Archive'.PlaybookCode::closingTag($button)."\n";
    $sample .= '    '.PlaybookCode::openingTag($button, [
        PlaybookCode::attribute('variant', 'outline'),
    ]).'Report'.PlaybookCode::closingTag($button)."\n";
    $sample .= '    '.PlaybookCode::openingTag($button, [
        PlaybookCode::attribute('variant', 'outline'),
    ]).'Snooze'.PlaybookCode::closingTag($button)."\n";
    $sample .= PlaybookCode::closingTag($buttonGroup);

    $codeBlock = PlaybookCode::component('code-block');

    $code = PlaybookCode::openingTag($codeBlock, [
        PlaybookCode::attribute('language', $language, 'blade'),
        PlaybookCode::boolean('copyable', $showCopy, true),
    ])."\n";
    $code .= $sample."\n";
    $code .= PlaybookCode::closingTag($codeBlock);

    echo $code;
@endphp
