<div class="overflow-x-auto rounded-xl border border-zinc-200">
    <table class="min-w-full divide-y divide-zinc-200 text-left text-sm">
        <thead class="bg-zinc-50">
            <tr>
                @foreach ($widget['content']['columns'] ?? [] as $column)
                    <th scope="col" class="px-4 py-3 font-semibold text-zinc-700">
                        {{ $column }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-100">
            @foreach ($widget['content']['rows'] ?? [] as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td class="px-4 py-3 text-zinc-600">{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>