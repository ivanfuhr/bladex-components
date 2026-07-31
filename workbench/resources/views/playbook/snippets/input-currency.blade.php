@php
    use Workbench\App\Playbook\PlaybookCode;

    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $readonly = (bool) ($state['readonly'] ?? false);
    $value = (float) ($state['value'] ?? 1234.56);
    $currency = (string) ($state['currency'] ?? 'BRL');
    $locale = (string) ($state['locale'] ?? 'pt_BR');

    $tag = PlaybookCode::component('input.currency');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'amount'),
        PlaybookCode::bound('value', $value),
        PlaybookCode::attribute('currency', $currency),
        PlaybookCode::attribute('locale', $locale),
        PlaybookCode::attribute(':precision', '2'),
        PlaybookCode::attribute('placeholder', '0,00'),
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
        PlaybookCode::boolean('readonly', $readonly),
    ]));

    echo $open."\n".PlaybookCode::closingTag($tag);
@endphp
