export default {
  state: {
    products: []
  },

  getters: {
    products: state => state.products,
  },

  mutations: {
    ADD_PRODUCT (state, value) {
      state.products.push(value)
    },

    REMOVE_PRODUCT (state, value) {
      state.products = state.products.filter(product => product !== value)
    }
  },

  actions: {
    async addProduct ({ commit, rootState }, product) {
      commit('ADD_PRODUCT', product)

      await axios.post(`/carts/${rootState.user.cart.id}/product/${product.id}`)
    },

    async removeProduct({ commit, rootState }, product) {
      commit('REMOVE_PRODUCT', product)

      await axios.delete(`/carts/${rootState.user.cart.id}/items/${product.id}`)
    }
  }
}