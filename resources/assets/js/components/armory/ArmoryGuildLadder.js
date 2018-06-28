export default {
	data () {
		return {
			query: '',

			sortOptions: [
		      {name: 'guilds', label: 'Most relevant'},
		      {name: 'guilds_rank_asc', label: 'Lowest rank'},
		      {name: 'guilds_rank_desc', label: 'Highest rank'},
		      {name: 'guilds_level_asc', label: 'Lowest level'},
		      {name: 'guilds_leveldesc', label: 'Highest level'}
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
	},

    render () {
        return this.$scopedSlots.default({
			algoliaAppId: this.algoliaAppId,
			algoliaSearchKey: this.algoliaSearchKey,
			query: this.query,
			sortOptions: this.sortOptions
		})
    }
}