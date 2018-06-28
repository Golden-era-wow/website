<template>
	<div>
		<slot :guilds="guilds">
			<!-- Render guilds -->
		</slot>

		<pagination :records="totalGuilds" @paginate="fetchGuilds"></pagination>
	</div>
</template>

<script>
import Pagination from '../Pagination.vue';

export default {
	components: { Pagination },

	data () {
		return {
			totalGuilds: 0,
			guilds: []
		}
	},

	mounted () {
		this.fetchGuilds();
	},

	methods: {
		async fetchGuilds(page = 0) {
			const { data } = await axios.get('/api/guilds', { params: { page: page } })

			this.totalGuilds = data.meta.total;
			this.guilds = data.data;
		}
	}
}
</script>