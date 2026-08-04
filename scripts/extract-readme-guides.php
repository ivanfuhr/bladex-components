<?php

declare(strict_types=1);

/**
 * One-off extractor: README component sections → workbench markdown guides.
 * Run: php scripts/extract-readme-guides.php
 */
$root = dirname(__DIR__);
$readme = file_get_contents($root.'/README.md');
$outDir = $root.'/workbench/resources/docs/components';

if (! is_dir($outDir) && ! mkdir($outDir, 0755, true) && ! is_dir($outDir)) {
    fwrite(STDERR, "Could not create {$outDir}\n");
    exit(1);
}

$skip = [
    'installation',
    'usage',
    'development',
    'changelog',
    'contributing',
    'security',
    'credits',
    'license',
    'input-enhancements',
    'textarea-enhancements',
    'combobox-multiple',
];

$mergeInto = [
    'input-enhancements' => 'input',
    'textarea-enhancements' => 'textarea',
    'combobox-multiple' => 'combobox',
];

preg_match_all('/^## ([^\n]+)\n(.*?)(?=^## |\z)/ms', $readme, $matches, PREG_SET_ORDER);

$guides = [];

foreach ($matches as $match) {
    $title = trim($match[1]);
    $body = trim($match[2]);
    $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
    $slug = trim($slug, '-');

    if (in_array($slug, $skip, true)) {
        continue;
    }

    if (isset($mergeInto[$slug])) {
        $slug = $mergeInto[$slug];
        $guides[$slug] = ($guides[$slug] ?? '')."\n\n### ".str_replace(' enhancements', '', $title)."\n\n".$body;

        continue;
    }

    $guides[$slug] = $body;
}

foreach ($guides as $slug => $body) {
    $body = preg_replace('/<picture>.*?<\/picture>\s*/s', '', $body);
    $body = preg_replace('/```bash\s*```/s', '', $body);
    $body = preg_replace("/\n{3,}/", "\n\n", trim($body));

    $path = $outDir.'/'.$slug.'.md';
    file_put_contents($path, $body."\n");
    echo "Wrote {$slug}.md\n";
}

echo count($guides)." guides written to {$outDir}\n";
