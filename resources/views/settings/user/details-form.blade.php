<form class="w-full mb-3 mt-3 text-center">
    <div class="w-full px-3">
        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-name">
            {{ __('Name') }}
        </label>
        <input v-model="form.name" class="text-center appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3 leading-tight" id="grid-name" name="name" type="text">
    </div>
    <div class="w-full px-3">
        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-email">
            {{ __('Email') }}
        </label>
        <input v-model="form.email" class="text-center appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight" id="grid-email" name="email" type="email">
    </div>

    <button @click="update" class="w-full bg-brand hover:bg-brand-dark text-white font-bold py-2 px-4 mb-4 rounded">
        <i class="fa fa-spinner fa-spin" v-if="form.processing"></i>
        {{ __('Update') }}
    </button>

    <button @click="destroy" class="w-full bg-red hover:bg-red-dark text-white font-bold py-2 px-4 mb-4 rounded">
        {{ __('Delete') }}
    </button>
</form>
