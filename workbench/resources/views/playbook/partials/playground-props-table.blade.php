@props([
    'controls' => [],
])

@if (count($controls) > 0)
    <div class="overflow-hidden rounded-xl border border-zinc-200/80 dark:border-zinc-800">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-zinc-200/80 bg-zinc-50/80 dark:border-zinc-800 dark:bg-zinc-900/60">
                <tr>
                    <th scope="col" class="px-4 py-2.5 font-semibold text-zinc-900 dark:text-zinc-100">Property</th>
                    <th scope="col" class="px-4 py-2.5 font-semibold text-zinc-900 dark:text-zinc-100">Type</th>
                    <th
                        scope="col"
                        class="hidden px-4 py-2.5 font-semibold text-zinc-900 sm:table-cell dark:text-zinc-100"
                    >
                        Default
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200/80 dark:divide-zinc-800">
                @foreach ($controls as $control)
                    <tr>
                        <td class="px-4 py-2.5 font-mono text-xs text-zinc-800 dark:text-zinc-200">
                            {{ $control->key }}
                        </td>
                        <td class="px-4 py-2.5 text-zinc-600 dark:text-zinc-400">{{ $control->type }}</td>
                        <td class="hidden px-4 py-2.5 font-mono text-xs text-zinc-500 sm:table-cell dark:text-zinc-500">
                            @if ($control->type === 'checkbox')
                                {{ $control->default ? 'true' : 'false' }}
                            @elseif ($control->type === 'select' && $control->default !== null && $control->default !== '')
                                {{ $control->default }}
                            @elseif ($control->type === 'text' && filled($control->default))
                                {{ $control->default }}
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
