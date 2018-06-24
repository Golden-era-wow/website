<table class="w-full border border-collapse">
    <thead>
        <tr class="mb-4">
            <th class="p-2">Client ID</th>
            <th class="p-2">Name</th>
            <th class="p-2">Secret</th>
            <th class="p-2"></th>
            <th class="p-2"></th>
        </tr>
    </thead>

    <tbody class="bg-brand-lightest flex-col items-center justify-between overflow-scroll">
        <tr class="mb-4" v-for="client in clients">
            <td class="p-4">@{{ client.id }}</td>
            <td class="p-4">@{{ client.name }}</td>
            <td class="p-4">@{{ client.secret }}</td>
            <!-- Edit Button -->
            <td class="self-align-center">
                <button class="w-full bg-transparent hover:bg-brand text-brand-dark font-semibold hover:text-white py-2 px-4 border border-brand hover:border-transparent" tabindex="-1" @click="edit(client)">
                    {{ __('Edit') }}
                </button>
            </td>

            <!-- Delete Button -->
            <td class="self-align-center">
                <button class="w-full bg-transparent hover:bg-red text-red-dark font-semibold hover:text-white py-2 px-4 border border-red hover:border-transparent" tabindex="-1" @click="destroy(client)">
                    {{ __('Delete') }}
                </button>
            </td>
        </tr>
    </tbody>
</table>
