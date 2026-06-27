import { GraphQLResponseError } from './responseError.js'

export async function graphQLRequest(query, variables = {}, accessToken = null) {
    const headers = {
        'Content-Type': 'application/json',
    }

    if (accessToken) {
        headers.Authorization = `Bearer ${accessToken}`
    }

    const response = await fetch('/graphql', {
        method: 'POST',
        headers,
        body: JSON.stringify({ query, variables }),
    })
    
    const result = await response.json()

    if (result.errors?.length > 0) {
        throw new GraphQLResponseError(result.errors)
    }
    
    return result.data
}
