<passport-personal-access-tokens>
    <div class="w-full mx-auto " slot-scope="{ tokens, scopes, createToken, creatingToken, store, form }">
        <button @click="createToken" class="bg-transparent hover:bg-brand text-brand-dark font-semibold hover:text-white py-2 px-4 border border-brand hover:border-transparent">
            {{ __('Create personal access token') }}
        </button>

        <template v-if="tokens.length === 0">
            @include('settings.passport.no-personal-access-tokens-alert')
        </template>

        <transition name="slide-fade">
            <template v-if="creatingToken">
                @include('settings.passport.personal-access-token-form')
            </template>
        </transition>

        <transition name="fade">
            <template v-if="! creatingToken">
                @include('settings.passport.personal-access-tokens-table')
            </template>
        </transition>
    </div>
</passport-personal-access-tokens>
