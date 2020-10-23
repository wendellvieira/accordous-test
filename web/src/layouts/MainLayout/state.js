export default {
	namespaced: true,
	state() {
		return {
			page_name: "Home"
		}
	},
	mutations: {
		SET_PAGE(state, payload){
			state.page_name = payload
		}
	}
}
