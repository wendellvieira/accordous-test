
import { Yup, errorTransform } from "./yup-utils"

export default {
	email: "",
	cep: "",
	logradouro: "",
	bairro: "",
	localidade: "",
	uf: "",
	numero: "",
	complemento: "",
}

export const schema = Yup.object().shape({
	email: Yup.string()
		.email("Este email não é válido!")
		.required("O campo email é obrigatório!"),

	cep: Yup.string()
		.min(9, "O cep inválido!")
		.max(9, "O cep inválido!")
		.required("O campo CEP é obrigatório!"),

	logradouro: Yup.string()
		.required("O campo Rua é obrigatório!"),

	bairro: Yup.string()
		.required("O campo Bairro é obrigatório!"),

	localidade: Yup.string()
		.required("O campo Cidade é obrigatório!"),

	uf: Yup.string()
		.max(2, "Informe a abreviação do estado Ex: RJ")
		.min(2, "São nessessários 2 caracteres Ex: RJ")
		.required("O campo Uf é obrigatório!"),

	numero: Yup.string()
		.required("O campo Número é obrigatório!"),

	complemento: Yup.string()
})

export const validate = async (data) => await errorTransform( schema, data )

