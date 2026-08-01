@php
    use Workbench\App\Playbook\PlaybookCode;

    $variant = ($state['variant'] ?? 'success') === 'default' ? null : (string) $state['variant'];
    $position = $state['position'] ?? 'bottom-right';

    $provider = PlaybookCode::component('toast.provider');
    $toast = PlaybookCode::component('toast');

    $titles = [
        'default' => 'Saved',
        'success' => 'Invite sent',
        'warning' => 'Heads up',
        'danger' => 'Upload failed',
    ];
    $descriptions = [
        'default' => 'Your changes were saved.',
        'success' => 'Taylor can now join the workspace.',
        'warning' => 'Your trial ends in 3 days.',
        'danger' => 'The file was too large. Try again.',
    ];
    $key = $variant ?? 'default';

    $code = PlaybookCode::openingTag($provider, array_filter([
        PlaybookCode::attribute('position', $position, 'bottom-right'),
    ]))."\n";
    $code .= '    '.PlaybookCode::selfClosingTag($toast, array_filter([
        PlaybookCode::attribute('variant', $variant),
        PlaybookCode::attribute('title', $titles[$key]),
        PlaybookCode::attribute('description', $descriptions[$key]),
    ]))."\n";
    $code .= PlaybookCode::closingTag($provider);

    echo $code;
@endphp
