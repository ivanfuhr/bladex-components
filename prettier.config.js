/** @type {import('prettier').Config} */
export default {
    printWidth: 100,
    tabWidth: 4,
    singleQuote: true,
    trailingComma: 'all',
    plugins: ['prettier-plugin-blade', 'prettier-plugin-tailwindcss'],
    overrides: [
        {
            files: ['*.blade.php'],
            options: {
                parser: 'blade',
            },
        },
        {
            files: ['*.{yml,yaml,json,md}'],
            options: {
                tabWidth: 2,
            },
        },
    ],
};
