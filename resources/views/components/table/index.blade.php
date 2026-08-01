<div {{
    $attributes->class([
        'table-wrap',
        'relative w-full overflow-x-auto',
    ])->merge([
        'data-table' => true,
    ])
}}>
    <table class="table w-full caption-bottom text-sm">
        {{ $slot }}
    </table>
</div>
