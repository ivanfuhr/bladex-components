@php
    use Workbench\App\Playbook\PlaybookCode;

    $name = (string) ($state['name'] ?? 'Std Components Inc.');
    $href = (string) ($state['href'] ?? '/');
    $useLogoUrl = (bool) ($state['use_logo_url'] ?? false);

    $brand = PlaybookCode::component('brand');

    if ($useLogoUrl) {
        $code = PlaybookCode::openingTag($brand, array_filter([
            PlaybookCode::attribute('href', $href, '/'),
            PlaybookCode::attribute('name', $name, ''),
            PlaybookCode::attribute('logo', '/logo.svg'),
            PlaybookCode::attribute('alt', 'Acme'),
        ])).' />';
    } else {
        $code = PlaybookCode::openingTag($brand, array_filter([
            PlaybookCode::attribute('href', $href, '/'),
            PlaybookCode::attribute('name', $name, ''),
        ]))."\n";
        $code .= '    <x-slot:logo>'."\n";
        $code .= '        <span class="text-xs font-bold">S</span>'."\n";
        $code .= '    </x-slot:logo>'."\n";
        $code .= PlaybookCode::closingTag($brand);
    }

    echo $code;
@endphp
