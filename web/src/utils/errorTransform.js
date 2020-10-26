export default async function errorTransform( schema, data, abortEarly = false ) {
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
