
import { Yup, errorTransform } from "./yup-utils"

export default {
	nome: '',
	email: '',
	tipo_documento: 'cpf',
	documento: '',

	propriedade: null,
}

export const schema = Yup.object().shape({
	nome: Yup.string()
		.required("O campo nome é obrigatório!")
		.min(3, "O nome precisa ter mais que 3 letras!"),

	email: Yup.string()
		.email("Este email não é válido!")
		.required("O campo email é obrigatório!"),

	tipo_documento: Yup.string()
		.required("Selecione o tipo de decumento!")
		.matches(/cpf|cnpj/gi, "Tipo de documento inválido!"),

	documento: Yup.string()
		.cpfOrCnpj("CPF ou CNPJ inválio!")
		.required("O campo documeto é obrigatório!"),

	propriedade: Yup.number()
		.required("É obrigatório definir uma propriedade!"),
})


export const validate = async (data) => await errorTransform( schema, data )
