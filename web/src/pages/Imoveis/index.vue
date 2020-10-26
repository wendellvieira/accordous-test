<template>
    <q-page>
        <q-table
            class='no-shadow'
            :data="data"
            :columns="columns"
            row-key="id">

            <template v-slot:body="props">
                <q-tr :props="props">
                    <q-td key="id" :props="props">
                        {{ props.row.id }}
                    </q-td>

                    <q-td key="email" :props="props">
                        {{ props.row.email }}
                    </q-td>

                    <q-td key="endereco" :props="props">
                        {{props.row.logradouro}},
                        {{props.row.numero}},
                        {{props.row.localidade}},
                        {{props.row.uf}}
                    </q-td>

                    <q-td key="status" :props="props">
                        <q-badge color="green">
                            Contratado
                        </q-badge>
                    </q-td>
                    <q-td key="acao" :props="props">
                        <imovel-delete :imovel='props.row' />
                    </q-td>
                </q-tr>
            </template>

        </q-table>

        <q-page-sticky position="bottom-right" :offset="[18, 18]">
            <q-fab color="primary" icon="add" direction="up">
                <q-fab-action
                    external-label
                    label-position="left"
                    label='Novo Imovel'
                    color="positive"
                    icon="business"
                    to='/imoveis/novo' />
                <q-fab-action
                    external-label
                    label-position="left"
                    label='Novo Contrato'
                    color="secondary"
                    icon="file_copy"
                    @click='$refs.MdNovoContrato.open()' />
            </q-fab>
        </q-page-sticky>

        <md-novo-contrato ref='MdNovoContrato' />
    </q-page>
</template>

<script>
import SetPageMixin from "utils/setPage.mixin"
import ImovelDelete from "./components/imovel-delete"
import MdNovoContrato from "./components/md-novo-contrato"

export default {

    components: {
        ImovelDelete,
        MdNovoContrato
    },

    provide() {
        return {
            $update: fx => this.list(fx),
            $getImoveis: () => this.data
        }
    },

    mixins: [
        SetPageMixin
    ],

    data() {
        return {
            data: [],
            columns: [{
                    name: "id",
                    label: '#',
                    align: 'left',
                    sortable: true,
                    field: 'id'
                },
                {
                    name: 'email',
                    label: 'Email',
                    align: 'left',
                    field: 'email',
                    sortable: true
                },
                {
                    name: 'endereco',
                    label: 'Endereço',
                    align: 'left',
                    field: row => `${row.logradouro}, ${row.numero}, ${row.localidade}, ${row.uf}`,
                    sortable: true
                },
                {
                    name: 'status',
                    label: 'Status',
                    align: 'left',
                    field: () => false,
                    sortable: true
                },
                {
                    name: 'acao',
                    label: '',
                    align: 'right',
                    field: () => false
                },
            ]
        }
    },

    methods: {

        async list(fx = null) {
            const req = await this.$axios.get("/imoveis")

            if (!!fx) fx()

            this.data = req.data
        }
    },

    mounted() {
        this.$setPage("Imoveis")
        this.list()
    },

}
</script>

<style lang="scss" scoped>

</style>
