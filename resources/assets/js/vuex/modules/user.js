export default {
	state: {
		user: {}
	},

	getters: {
		user: state => state.user
	},

	mutations: {
		SET_USER (state, value) {
			state.user = value
		}
	},

	actions: {
		setUser ({ commit }, value) {
			commit('SET_USER', value)
		}
	}
}