<template>
    <q-page>
        Imoveis
    </q-page>
</template>

<script>
import SetPageMixin from "utils/setPage.mixin"

export default {
    mixins: [
        SetPageMixin
    ],

    mounted() {
        this.$setPage("Imoveis")
    },

}
</script>

<style lang="scss" scoped>

</style>
