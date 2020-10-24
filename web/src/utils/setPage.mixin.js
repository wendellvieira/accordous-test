import {
    mapMutations
} from "vuex"

export default {
	methods: {
        ...mapMutations("MAIN_LAYOUT", {
            $setPage: "SET_PAGE"
        })
	},
}
