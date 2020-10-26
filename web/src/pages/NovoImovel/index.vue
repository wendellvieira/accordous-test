<template>
    <q-page>
        <div class="cnt-form q-ma-lg q-gutter-y-lg">

            <q-input
                outlined
                v-model="data.email"
                label="Email"
                :error-message='errors.email'
                :error='!!errors.email' />

            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <q-input
                        outlined
                        v-model="data.cep"
                        :loading='cepLoading'
                        :readonly='disabled.cep'
                        mask='#####-###'
                        :error='cepError || !!errors.cep'
                        :error-message=' !!errors.cep ? errors.cep : "Entre com os dados manualmente!"'
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
                        label="Cidade"
                        :error-message='errors.localidade'
                        :error='!!errors.localidade' />
                </div>

                <div class="col-sm-4 col-xs-12">
                    <q-input
                        outlined
                        v-model="data.uf"
                        :readonly='disabled.uf'
                        label="UF"
                        :error-message='errors.uf'
                        :error='!!errors.uf' />
                </div>
            </div>

            <div class="row q-col-gutter-x-lg ">
                <div class="col-sm-6 col-xs-12">
                    <q-input
                        outlined
                        v-model="data.logradouro"
                        :readonly='disabled.logradouro'
                        label="Rua"
                        :error-message='errors.logradouro'
                        :error='!!errors.logradouro' />

                </div>
                <div class="col-sm-6 col-xs-12">
                    <q-input
                        outlined
                        v-model="data.bairro"
                        :readonly='disabled.bairro'
                        label="Bairro"
                        :error-message='errors.bairro'
                        :error='!!errors.bairro' />

                </div>
            </div>

            <div class="row q-col-gutter-x-lg ">
                <div class="col-sm-6 col-xs-12">
                    <q-input
                        outlined
                        v-model="data.numero"
                        ref='numero'
                        label="Número"
                        :error-message='errors.numero'
                        :error='!!errors.numero' />
                </div>
                <div class="col-sm-6 col-xs-12">
                    <q-input
                        outlined
                        v-model="data.complemento"
                        label="Complemento"
                        :error-message='errors.complemento'
                        :error='!!errors.complemento' />
                </div>
            </div>

            <div class="">
                <q-btn
                    label='Criar imovel'
                    @click='salvarImovel'
                    color='primary'
                    size='lg'
                    :loading='sending'
                    :disable='sending' />
            </div>

        </div>

    </q-page>
</template>

<script>
import SetPageMixin from "utils/setPage.mixin"

import {
    positive,
    error
} from "utils/notifications"

import defaultData, {
    validate
} from "./dbo"

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
            },
            errors: {},

            sending: false
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
        async salvarImovel() {
            try {
                this.sending = true
                this.$set(this, 'errors', {})
                const err = await validate(this.data)

                if (!!err) {
                    this.$set(this, 'errors', err)
                    this.sending = false
                    return;
                }

                await this.$axios.post("/imoveis", this.data)

                this.$q.notify(positive)

                this.$set(this, 'data', clone(defaultData))
                this.sending = false

            } catch (e) {
                this.$q.notify({
                    ...error,
                    message: 'Não foi possível salvar os dados!'
                })
                this.sending = false
            }
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
