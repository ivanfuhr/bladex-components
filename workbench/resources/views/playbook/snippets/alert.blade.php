@php
    use Workbench\App\Playbook\PlaybookCode;

    $variant = ($state['variant'] ?? 'info') === 'default' ? null : (string) $state['variant'];
    $showIcon = (bool) ($state['show_icon'] ?? true);

    $alert = PlaybookCode::component('alert');
    $description = PlaybookCode::component('alert.description');

    $titles = [
        'default' => 'Note',
        'info' => 'Tip',
        'success' => 'Payment received',
        'warning' => 'Heads up',
        'danger' => 'Action required',
    ];
    $descriptions = [
        'default' => 'This is a neutral status message.',
        'info' => 'You can copy this invite link anytime.',
        'success' => 'Invoice INV-204 was marked as paid.',
        'warning' => 'Check your billing details before renewing.',
        'danger' => 'Your API key was revoked. Generate a new one.',
    ];
    $icons = [
        'info' => 'clipboard',
        'success' => 'check',
    ];
    $key = $variant ?? 'default';

    $attrs = array_filter([
        PlaybookCode::attribute('variant', $variant),
        PlaybookCode::attribute('title', $titles[$key]),
        $showIcon && isset($icons[$key]) ? PlaybookCode::attribute('icon', $icons[$key]) : null,
    ]);

    $code = PlaybookCode::openingTag($alert, $attrs)."\n";
    $code .= '    <'.$description.'>'.$descriptions[$key].'</'.$description.'>'."\n";
    $code .= PlaybookCode::closingTag($alert);

    echo $code;
@endphp
