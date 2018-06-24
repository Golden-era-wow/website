<form class="w-full max-w-md m-0-auto">
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-name">
                {{ __('Name') }}
            </label>
            <input v-model="form.name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight" id="grid-name" type="text" placeholder="App name">
            <p class="text-grey-dark text-xs italic">{{ __('Name of the token, maybe the app intend to use it for?') }}</p>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
        <div v-for="scope in scopes" class="flex-1">
            <input v-model="form.scopes" :value="scope.id" :id="scope.id" class="shadow-inner" type="checkbox">
            <label class="text-brand-darkest mr-3 py-1 px-2 leading-tight" :for="scope.id">
                <tooltip :value="scope.description" trigger="hover" position="bottom">
                    @{{ scope.id }}
                </tooltip>
            </label>
        </div>
    </div>

    <button @click="store" class="w-full bg-green hover:bg-green-dark text-white font-bold py-2 px-4 mb-4 rounded">
        {{ __('Create') }}
    </button>
</form>
