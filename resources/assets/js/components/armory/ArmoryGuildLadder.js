import Pagination from '../Pagination.vue';

export default {
	components: { Pagination },

	data () {
		return {
			guilds: []
		}
	},

	mounted () {
		this.fetchLatestGuilds();
	},

	methods: {
		async fetchLatestGuilds () {
			const { data } = axios.get('/api/armory/guilds');


		}
	}
}