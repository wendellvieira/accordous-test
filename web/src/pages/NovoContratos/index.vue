<template>
    <q-page>
        contrato
    </q-page>
</template>

<script>
import SetPageMixin from "utils/setPage.mixin"

export default {
    mixins: [
        SetPageMixin
    ],

    mounted() {
        this.$setPage("Contratos")
    },

}
</script>

<style lang="scss" scoped>

</style>
