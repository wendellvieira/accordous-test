<template>
    <q-page>
        <div class="cnt-form q-ma-lg q-gutter-y-lg">

            <q-input outlined v-model="data.email" label="Email" />

            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <q-input
                        outlined
                        v-model="data.cep"
                        :loading='cepLoading'
                        :readonly='disabled.cep'
                        mask='#####-###'
                        :error='cepError'
                        error-message='Entre com os dados manualmente!'
                        label="CEP" />
                </div>
            </div>

            <div class="row q-col-gutter-x-lg ">
                <div class="col-sm-8 col-xs-12">
                    <q-input
                        ref='cidade'
                        outlined
                        v-model="data.localidade"
                        :readonly='disabled.localidade'
                        label="Cidade" />
                </div>

                <div class="col-sm-4 col-xs-12">
                    <q-input
                        outlined
                        v-model="data.uf"
                        :readonly='disabled.uf'
                        label="UF" />
                </div>
            </div>

            <div class="row q-col-gutter-x-lg ">
                <div class="col-sm-6 col-xs-12">
                    <q-input
                        outlined
                        v-model="data.logradouro"
                        :readonly='disabled.logradouro'
                        label="Rua" />

                </div>
                <div class="col-sm-6 col-xs-12">
                    <q-input
                        outlined
                        v-model="data.bairro"
                        :readonly='disabled.bairro'
                        label="Bairro" />

                </div>
            </div>

            <div class="row q-col-gutter-x-lg ">
                <div class="col-sm-6 col-xs-12">
                    <q-input
                        outlined
                        v-model="data.numero"
                        ref='numero'
                        label="Número" />
                </div>
                <div class="col-sm-6 col-xs-12">
                    <q-input outlined v-model="data.complemento" label="Complemento" />
                </div>
            </div>

            <div class="">
                <q-btn
                    label='Criar imovel'
                    @click='salvarImovel'
                    color='primary'
                    size='lg' />
            </div>

        </div>

    </q-page>
</template>

<script>
import SetPageMixin from "utils/setPage.mixin"
import defaultData from "./defaultData.js"

import {
    clone
} from "lodash"

export default {

    data() {
        return {
            data: clone(defaultData),
            cepLoading: false,
            cepError: false,
            disabled: {
                cep: false,
                localidade: true,
                uf: true,
                logradouro: true,
                bairro: true,
            }
        }
    },

    watch: {
        "data.cep": async function (cep) {
            this.cepError = false
            const claerCep = cep.replace("-", "")
            if (claerCep.length == 8) {
                try {
                    this.disabled.cep = true
                    this.cepLoading = true

                    const httpReq = await fetch(`https://viacep.com.br/ws/${claerCep}/json/`)
                    const data = await httpReq.json()

                    if (data.erro) throw new Exception();

                    this.$set(this, "data", {
                        ...this.data,
                        ...data
                    })

                    this.$refs.numero.focus()
                    this.disabled.cep = false
                    this.cepLoading = false

                } catch (e) {
                    // console.log(e)

                    this.$set(this, 'data', {
                        ...defaultData,
                        cep
                    })

                    this.disabled = {
                        cep: false,
                        uf: false,
                        bairro: false,
                        localidade: false,
                        logradouro: false,
                    }

                    this.cepLoading = false
                    this.cepError = true

                    this.$refs.cidade.focus()
                }

            }
        }
    },

    methods: {
        salvarImovel() {
            this.$axios.post("/imoveis", this.data)
        }
    },

    mixins: [
        SetPageMixin
    ],

    mounted() {
        this.$setPage("Criar Imovel")
    }
}
</script>

<style lang="scss" scoped>
.cnt-form {
    max-width: 600px;
}
</style>
