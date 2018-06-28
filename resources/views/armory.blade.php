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
                    <div class="container text-center mb-4 mx-auto" slot-scope="{ algoliaAppId, algoliaSearchKey, query, sortOptions }">
                            <input v-model="query" placeholder="Search for guilds">

                            <ais-index :app-id="algoliaAppId" :api-key="algoliaSearchKey" index-name="guilds" :query-parameters="{query: query}">
                                <ais-results class="flex sm:inline-flex md:block lg:hidden xl:flex flex-wrap">
                                <div slot="header" class="w-full">
                                    <h2>{{ __('Guilds') }}</h2>
                                    <ais-stats></ais-stats>
                    
                                    <ais-sort-by-selector :indices="sortOptions">
                                    <template slot-scope="{ indexName, label }">
                                        <option :value="indexName">{{ __('Sort by') }}: @{{ label }}</option>
                                    </template>
                                    </ais-sort-by-selector>
                                </div>
                    
                                <hr class="divider"></hr>
                    
                                <template slot-scope="{ result }">
                                    <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 mx-2 mb-4 rounded overflow-hidden shadow-lg">
                                    <img class="w-full" :src="result.faction_banner_url" :alt="result.faction"">
                                    <div class="px-6 py-4">
                                        <div class="font-bold text-xl mb-2">
                                            <ais-highlight :result="result" attribute-name="name"/>
                                        </div>
                                        <h3 class="font-thin">
                                            <ais-highlight :result="result" attribute-name="realm"/>
                                        </h3>
                                        <p class="text-grey-darker text-base">
                                            <ais-highlight :result="result" attribute-name="info"/>
                                        </p>
                                    </div>
                                        <!-- level ribbon -->
                                        <span class="inline-block bg-brand-darker rounded-full px-3 py-1 text-sm font-semibold text-brand-light mr-2">
                                        {{ __('Level') }}: @{{ result.level }} <i class="fa fa-ribbon"></i>
                                        </span>
                                        <!-- rank ribbon -->
                                        <span class="inline-block bg-brand-darker rounded-full px-3 py-1 text-sm font-semibold text-brand-light mr-2">
                                        {{ __('Rank') }}: @{{ result.rank }} <i class="fa fa-ribbon"></i>
                                        </span>
        
                                    <div class="px-6 py-4">
                                        <a :href="result.link" class="bg-transparent hover:bg-blue text-blue-dark font-semibold hover:text-white py-2 px-4 border border-blue hover:border-transparent rounded">
                                        {{ __('Details') }}
                                        </a>
                                    </div>
                                    </div>
                                </template>
                                </ais-results>
                            </ais-index>
                    
                            <ais-powered-by />
                    </div>
                </armory-guild-ladder>
            </tab>
        </tabs>
    </armory-index>
@endsection
