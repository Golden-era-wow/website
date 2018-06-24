<div class="bg-brand-lightest border-t-4 border-brand rounded-b text-brand-darkest px-4 py-3 shadow-md my-2" role="alert">
    <div class="flex">
        <svg class="h-6 w-6 text-brand mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg>
        <div>
        <p class="font-bold">{{ __('You have no OAuth clients.') }}</p>
        {{-- <button @click="create" class="bg-transparent hover:bg-brand text-brand-dark font-semibold hover:text-white py-2 px-4 border border-brand hover:border-transparent rounded">
            {{ __('Click here to create one.') }}
        </button> --}}
        </div>
    </div>
</div>
