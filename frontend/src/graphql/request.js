import { GraphQLResponseError } from './responseError.js'

export async function graphQLRequest(query, variables = {}) {
    const response = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query, variables }),
    })
    
    const result = await response.json()

    if (result.errors?.length > 0) {
        throw new GraphQLResponseError(result.errors)
    }
    
    return result.data
}
