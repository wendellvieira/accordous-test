<template>
    <q-btn
        flat
        round
        color="negative"
        icon='delete_outline'
        @click='apagarImovel'
        :loading='sending'
        :disable='sending' />
</template>

<script>
import {
    positive,
    error
} from "utils/notifications"

export default {
    props: [
        'imovel'
    ],
    inject: ["$update"],
    data() {
        return {
            sending: false
        }
    },
    methods: {
        async apagarImovel() {
            try {
                this.sending = true

                await this.$axios.delete(`/imoveis/${this.imovel.id}`)

                this.$q.notify({
                    ...positive,
                    message: "Registro excluído com sucesso!"
                })

                this.$update()

                this.sending = false

            } catch (e) {
                console.log(e)

                this.$q.notify({
                    ...error,
                    message: "Não conseguimos excluir o registro!"
                })

                this.sending = false

            }

        },
    },
}
</script>

<style lang="scss" scoped>

</style>
