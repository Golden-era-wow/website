<template>
  <on-click-outside :do="hide">
    <div class="relative">
      <button @click="toggle" type="button" class="inline-block select-none font-semibold px-4 py-2 focus:outline-0">
        <slot name="link" :toggle="toggle">
          Dropdown
        </slot>
      </button>
      <div v-show="open" class="absolute pin-l mt-px text-sm text-center text-grey-darker leading-normal bg-white border p-4">
        <slot name="content" :isOpen="open">
          Dropdown Content
        </slot>
      </div>
      </slot>
    </div>
  </on-click-outside>
</template>

<script>
  import OnClickOutside from '../functional/OnClickOutside.vue'

	export default {
    components: { OnClickOutside },

	  data() {
	    return {
	      open: false
	    }
	  },

    methods: {
      toggle () {
        this.open = ! this.open
      },

      hide () {
        this.open = false
      }
    }
	}
</script>