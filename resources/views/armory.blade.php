@extends('layouts.app')

@section('content')
    <armory-index inline-template>
        <tabs>
            <tab name="pvp">
                <armory-pvp-ladder>

                </armory-pvp-ladder>
            </tab>

            <tab name="pve">
                <armory-pve-ladder>

                </armory-pve-ladder>
            </tab>

            <tab name="guilds">
                <armory-guild-ladder>
                    <table class="w-full border border-collapse" slot-scope="{ guilds }">
                        <thead>
                            <tr class="mb-4">
                                <th class="p-2">{{ __('Name') }}</th>
                                <th class="p-2">{{ __('Leader') }}</th>
                                <th class="p-2">{{ __('Level') }}</th>
                                <th class="p-2">{{ __('Rank') }}</th>
                                <th class="p-2">{{ __('Realm') }}</th>
                            </tr>
                        </thead>

                        <tbody class="bg-brand-lightest flex-col items-center justify-between overflow-scroll">
                            <tr class="mb-4" v-for="guild in guilds">
                                <td class="p-4">@{{ guild.name }}</td>
                                <td class="p-4">@{{ guild.leader }}</td>
                                <td class="p-4">@{{ guild.level }}</td>
                                <td class="p-4">@{{ guild.rank }}</td>
                                <td class="p-4">@{{ guild.realm }}</td>
                            </tr>
                        </tbody>
                    </table>
                </armory-guild-ladder>
            </tab>
        </tabs>
    </armory-index>
@endsection
