<table class="w-full border border-collapse">
    <thead>
        <tr class="mb-4">
            <th class="p-2">Name</th>
            <th class="p-2">Scopes</th>
        </tr>
    </thead>

    <tbody class="bg-brand-lightest flex-col items-center justify-between overflow-scroll">
        <tr class="mb-4" v-for="token in tokens">
            <td class="p-4">@{{ token.name }}</td>
            <td class="p-4">@{{ token.scopes.join(', ') }}</td>
        </tr>
    </tbody>
</table>
