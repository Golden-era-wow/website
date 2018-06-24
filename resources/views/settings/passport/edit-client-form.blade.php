<form class="w-full max-w-md m-0-auto">
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-name">
                {{ __('Name') }}
            </label>
            <input v-model="editForm.name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight" id="grid-name" type="text" placeholder="Stature of the Gods">
            <p class="text-grey-dark text-xs italic">{{ __('Name of the token, maybe the app or domain you intend to use it for?') }}</p>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-redirect">
                {{ __('Redirect') }}
            </label>
            <input v-model="editForm.redirect" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight" id="grid-redirect" type="text" placeholder="http://sotg.sauft.org">
            <p class="text-grey-dark text-xs italic">{{ __("The url we'll redirect visitors of your app to after authenticating") }}</p>
        </div>
    </div>

    <button @click="update" class="w-full bg-green hover:bg-green-dark text-white font-bold py-2 px-4 mb-4 rounded">
        {{ __('Update') }}
    </button>
</form>
