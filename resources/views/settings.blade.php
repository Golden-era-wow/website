@extends('layouts.app')

@section('content')
	<app-settings :user="user" inline-template>
        <tabs>
            <tab name="{{ __('User') }}" prefix='<i class="fas fa-user-edit"></i>'>
                First tab content
            </tab>

            <tab name="{{ __('API') }}" prefix='<i class="fas fa-cogs"></i>'>
                <app-settings-passport :user="user">
                    <div class="shadow" slot-scope="{ showClients, showingClients, showTokens, showingTokens }">
                        <div class="w-1/2">
                            <ul class="list-reset border-b flex">
                                <li class="-mb-px mr-1">
                                    <button @click="showClients" class="block p-4 text-brand-darker font-bold hover:bg-brand-lighter" :class="{ 'hover:border-brand-light': ! showingClients, 'border-brand': showingClients }">
                                        {{ __('OAuth clients') }}
                                    </button>
                                </li>

                                <li class="-mb-px mr-1">
                                    <button @click="showTokens" class="block p-4 text-brand-darker font-bold hover:bg-brand-lighter" :class="{ 'hover:border-brand-light': ! showingTokens, 'border-brand': showingTokens }">
                                        {{ __('Personal access tokens') }}
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="border border-brand w-full">
                            <transition name="fade">
                                <template v-if="showingClients">
                                    @include('settings.passport.clients')
                                </template>
                            </transition>

                            <transition name="fade">
                                <template v-if="showingTokens">
                                    @include('settings.passport.personal-access-tokens')
                                </template>
                            </transition>
                        </div>
                    </div>
                </app-settings-passport>
            </tab>
        </tabs>
	</app-settings>
@endsection
