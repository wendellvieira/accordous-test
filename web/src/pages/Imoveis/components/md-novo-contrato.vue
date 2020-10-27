<template>
    <q-dialog v-model='dialog' persistent>
        <q-card style='width: 700px; max-width: 80vw;'>
            <q-card-section>
                <div class="text-h6">Novo contrato</div>
            </q-card-section>

            <q-separator />

            <q-card-section class="q-gutter-y-lg">

                <q-select
                    outlined
                    v-model="data.propriedade"
                    :options="imoveis"
                    label="Propriedade"
                    color="primary"
                    clearable
                    use-input
                    @filter="filterFn"
                    emit-value
                    map-options
                    :error-message='error.propriedade'
                    :error='!!error.propriedade'
                    options-selected-class="text-primary">
                    <template v-slot:option="scope">
                        <q-item v-bind="scope.itemProps" v-on="scope.itemEvents">
                            <q-item-section>
                                <q-item-label v-html="scope.opt.label" />
                                <q-item-label caption>{{ scope.opt.email }}</q-item-label>
                            </q-item-section>
                        </q-item>
                    </template>
                </q-select>

                <div class="row q-col-gutter-x-lg">
                    <div class="col-4">
                        <q-select
                            outlined
                            v-model="data.tipo_documento"
                            :options="tipos_documentos"
                            :error-message='error.tipo_documento'
                            :error='!!error.tipo_documento'
                            emit-value
                            map-options />
                    </div>
                    <div class="col">
                        <q-input
                            v-if='data.tipo_documento == "cpf"'
                            outlined
                            :error-message='error.documento'
                            :error='!!error.documento'
                            v-model="data.documento"
                            label="CPF"
                            mask='###.###.###-##' />

                        <q-input
                            v-else
                            outlined
                            :error-message='error.documento'
                            :error='!!error.documento'
                            v-model="data.documento"
                            label="CNPJ"
                            mask='##.###.###/####-##' />
                    </div>
                </div>

                <q-input
                    :error-message='error.nome'
                    :error='!!error.nome'
                    outlined
                    v-model="data.nome"
                    label="Nome" />

                <q-input
                    :error-message='error.email'
                    :error='!!error.email'
                    outlined
                    v-model="data.email"
                    label="Email" />

            </q-card-section>

            <q-separator />

            <q-card-actions align="right">
                <div class='q-pa-sm'>

                    <q-btn
                        flat
                        label="Cancelar"
                        color="primary"
                        class='q-mr-lg'
                        v-close-popup />

                    <q-btn
                        label="Gerar"
                        @click="criarContrato"
                        class='q-px-lg'
                        color="primary"
                        :loading='sending'
                        :disable='sending' />
                </div>
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script>
import defaultData, {
    validate
} from 'utils/dto/contrato'

import {
    clone
} from "lodash"

import {
    positive,
    error
} from "utils/notifications"

export default {
    inject: [
        "$getImoveis",
        "$update"
    ],
    data() {
        return {
            dialog: false,
            sending: false,
            search: '',
            error: {},

            tipos_documentos: [{
                label: 'Pessoa física',
                value: 'cpf'
            }, {
                label: 'Pessoa Jurídica',
                value: 'cnpj'
            }],

            data: clone(defaultData)
        }
    },
    computed: {
        imoveis() {
            const imoveis = this.$getImoveis().reduce((acc, imovel) => {
                if (!!imovel.contrato) return acc;

                acc.push({
                    value: imovel.id,
                    label: `${imovel.logradouro}, ${imovel.numero}, ${imovel.localidade}, ${imovel.uf}`,
                    email: imovel.email
                })

                return acc
            }, [])

            if (!this.search) return imoveis
            return imoveis.filter(item => {
                const inEmail = item.email.toLowerCase().indexOf(this.search) != -1
                const inLabel = item.label.toLowerCase().indexOf(this.search) != -1

                if (inEmail || inLabel) return item
            })
        }
    },
    methods: {
        async criarContrato() {
            try {
                this.sending = true
                this.error = {}

                const err = await validate(this.data)
                if (!!err) {
                    this.error = err
                    this.sending = false
                    return;
                }

                await this.$axios.post("/contratos", this.data)

                this.$update(() => {
                    this.$q.notify({
                        ...positive,
                        message: "Contrato criado com sucesso!"
                    })

                    this.$set(this, 'data', clone(defaultData))
                    this.sending = false
                    this.dialog = false
                })

                this.sending = false

            } catch (e) {
                console.log(e)
                this.$q.notify({
                    ...error,
                    message: "Erro ao eviar pedido!"
                })
                this.sending = false
            }
        },
        open() {
            this.dialog = true
        },
        filterFn(val, update, abort) {
            update(() => {
                this.search = val.toLowerCase()
            })
            abort(() => {
                this.search = ''
            })
        }
    },
}
</script>
