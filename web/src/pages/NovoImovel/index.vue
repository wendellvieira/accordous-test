<template>
	<q-page>
		Novo imovel
	</q-page>
</template>

<script>
	import { mapMutations } from "vuex"

	export default {

		methods: {
			...mapMutations("MAIN_LAYOUT", {
				$setPage: "SET_PAGE"
			})
		},

		mounted(){
			this.$setPage("Criar Imovel")
		}
	}
</script>

<style lang="scss" scoped>

</style>
