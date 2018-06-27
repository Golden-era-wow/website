<template>
	<ul class="flex list-reset border border-grey-light rounded w-auto font-sans">
	  	<li>
		  	<a @click="previous" class="block hover:text-white hover:bg-brand text-brand border-r border-grey-light px-3 py-2" href="#">
				<i class="fal fa-chevron-double-left"></i>
		  	</a>
		</li>

	  	<li v-for="number in pages">
	  		<a @click="fetch(number)" class="block text-white border-r border-brand px-3 py-2" :class="{ 'bg-brand': number === page }" href="#">
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
			url: {
				type: String,
				required: true
			},

			perPage: {
				type: Number,
				default: 15
			},

			scopes: {
				type: Object,
				default () {
					return {};
				}
			}
		},

		data () {
			return {
				page: 0,
				total: 0
			}
		},

		computed: {
			pages () {
				return [...Array(this.total).keys()];
			}
		},

		methods: {
			next () {
				this.fetch(this.page +1);
			},

			previous  () {
				this.fetch(this.page -1);
			},

			async fetch (page) {
				let scopes = this.scopes;
				scopes['page'] = page;

				const { data } = await axios.get(this.url, { params: scopes });

				if ('meta' in data) {
					this.page = data.meta.current_page;
					this.total = data.meta.total;
				} else {
					this.page = page;
				}

				this.$emit('data', get(data, 'data', data));
			},
		}
	}
</script>