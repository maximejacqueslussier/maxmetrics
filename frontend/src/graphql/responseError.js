export class GraphQLResponseError extends Error
{
    constructor(errors) {
        super(errors[0]?.message ?? 'GraphQL operation failed.')
        this.name = 'GraphQLResponseError'
        this.errors = errors
    }

    getFieldErrors() {
        return this.errors.reduce(
            (fields, error) => ({
                ...fields,
                ...(error.extensions?.fields ?? {}),
            }),
            {},
        )
    }
}
