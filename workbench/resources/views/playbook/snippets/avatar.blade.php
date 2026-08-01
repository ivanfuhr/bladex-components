@php
    use Workbench\App\Playbook\PlaybookCode;

    $size = ($state['size'] ?? 'default') === 'default' ? null : (string) $state['size'];
    $color = (string) ($state['color'] ?? 'violet');
    $circle = (bool) ($state['circle'] ?? true);
    $showGroup = (bool) ($state['show_group'] ?? false);

    $avatar = PlaybookCode::component('avatar');
    $group = PlaybookCode::component('avatar.group');

    $attrs = array_filter([
        PlaybookCode::attribute('name', 'Ada Lovelace'),
        PlaybookCode::attribute('size', $size),
        PlaybookCode::boolean('circle', $circle),
        PlaybookCode::attribute('color', $color),
    ]);

    if ($showGroup) {
        $people = [
            ['Ada Lovelace', 'violet'],
            ['Grace Hopper', 'blue'],
            ['Alan Turing', 'green'],
        ];

        $code = '<'.$group.'>'."\n";

        foreach ($people as $person) {
            $code .= '    '.PlaybookCode::selfClosingTag($avatar, array_filter([
                PlaybookCode::attribute('name', $person[0]),
                PlaybookCode::attribute('size', $size),
                PlaybookCode::boolean('circle', $circle),
                PlaybookCode::attribute('color', $person[1]),
            ]))."\n";
        }

        $code .= PlaybookCode::closingTag($group);
    } else {
        $code = PlaybookCode::selfClosingTag($avatar, $attrs);
    }

    echo $code;
@endphp
