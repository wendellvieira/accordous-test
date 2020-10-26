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
                            emit-value
                            map-options />
                    </div>
                    <div class="col">
                        <q-input
                            v-if='data.tipo_documento == "cpf"'
                            outlined
                            v-model="data.documento"
                            label="CPF"
                            mask='###.###.###-##' />
                        <q-input
                            v-else
                            outlined
                            v-model="data.documento"
                            label="CNPJ"
                            mask='##.###.###/####-##' />
                    </div>
                </div>

                <q-input outlined v-model="data.email" label="Nome" />

                <q-input outlined v-model="data.nome" label="Email" />

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

                    <q-btn label="Gerar" class='q-px-lg' color="primary" />
                </div>
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script>
import defaultData from 'utils/dbo/contrato'
import {
    clone
} from "lodash"
export default {
    inject: [
        "$getImoveis"
    ],
    data() {
        return {
            dialog: false,
            search: '',

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
            const imoveis = this.$getImoveis().map(imovel => {
                return {
                    value: imovel.id,
                    label: `${imovel.logradouro}, ${imovel.numero}, ${imovel.localidade}, ${imovel.uf}`,
                    email: imovel.email
                }
            })

            if (!this.search) return imoveis
            return imoveis.filter(item => {
                const inEmail = item.email.toLowerCase().indexOf(this.search) != -1
                const inLabel = item.label.toLowerCase().indexOf(this.search) != -1

                if (inEmail || inLabel) return item
            })
        }
    },
    methods: {
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
