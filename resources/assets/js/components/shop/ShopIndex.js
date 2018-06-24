Vue.component('shop-index', {
	data () {
		return {
			query: '',

			products: [],

			sortOptions: [
		      {name: 'products', label: 'Most relevant'},
		      {name: 'products_cost_asc', label: 'Lowest cost'},
		      {name: 'products_cost_desc', label: 'Highest cost'},
		      {name: 'products_total_sales', label: 'Popularity'}
		    ]
		}
	},

	computed: {
		algoliaAppId () {
			return window.Laravel.algolia_app_id;
		},

		algoliaSearchKey () {
			return window.Laravel.algolia_key;
		}
	}
})