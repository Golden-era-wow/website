<template>
	<ul class="flex list-reset border border-grey-light rounded w-auto font-sans">
	  	<li>
		  	<a @click="previous" class="block hover:text-white hover:bg-brand text-brand border-r border-grey-light px-3 py-2" href="#">
				<i class="fal fa-chevron-double-left"></i>
		  	</a>
		</li>

	  	<li v-for="number in pages">
	  		<a @click="setPage(number)" class="block text-white border-r border-brand px-3 py-2" :class="{ 'bg-brand': number === page }" href="#">
	  			{{ number }}
	  		</a>
	  	</li>

	  	<li>
	  		<a @click="next" class="block hover:text-white hover:bg-brand text-brand px-3 py-2" href="#">
				<i class="fal fa-chevron-double-right"></i>
	  		</a>
	  	</li>
	</ul>
</template>

<script>
	import { get } from 'lodash';

	export default {
		props: {
			records: {
				type: Number,
				required: true
			},

			perPage: {
				type: Number,
				default: 15
			}
		},

		data () {
			return {
				page: 0
			}
		},

		computed: {
			pages () {
				return [...Array(this.records).keys()];
			}
		},

		methods: {
			next () {
				this.page++;

				this.paginate();
			},

			previous () {
				this.page--;

				this.paginate();
			},

			paginate (page = null) {
				if (page) {
					this.page = page;
				}

				this.$emit('paginate', this.page);
			}
		}
	}
</script>