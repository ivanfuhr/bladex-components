@php
    use Workbench\App\Playbook\PlaybookCode;

    $orientation = ($state['orientation'] ?? 'horizontal') === 'vertical' ? 'vertical' : null;
    $tag = PlaybookCode::component('separator');

    if ($orientation === 'vertical') {
        echo PlaybookCode::selfClosingTag($tag, [
            PlaybookCode::attribute('orientation', 'vertical'),
            ':decorative="false"',
        ]);
    } else {
        echo PlaybookCode::selfClosingTag($tag);
    }
@endphp
