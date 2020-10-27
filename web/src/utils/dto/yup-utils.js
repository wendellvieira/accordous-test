import * as originalYup from "yup"
import { validate_cpf, validate_cnpj } from "utils/validates"

export async function errorTransform( schema, data, abortEarly = false ) {
	try {
		await schema.validate( data, {
			abortEarly
		})
	} catch( e ){
		return e.inner.reduce( (acc, err) => {
			acc[ err.path ] = err.errors[0]
			return acc
		}, {})
	}
}

originalYup.addMethod( originalYup.string, "cpfOrCnpj", function(message) {
	return this.test( function(value) {
		const { path, createError } = this

		const cpfIsValid = validate_cpf(value)
		const cnpjIsValid = validate_cnpj(value)

		return cpfIsValid || cnpjIsValid || createError( {path, message});
	})
})

export const Yup = originalYup
