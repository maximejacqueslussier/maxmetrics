import { graphQLRequest } from './request.js'

const LOGIN_MUTATION = `
    mutation Login($input: LoginInput!) {
        login(input: $input) {
            user {
                id
                username
                role
                salutation
                pronouns
                genderIdentity
                firstName
                middleName
                lastName
                email
                phoneNumber
            }
            accessToken
        }
    }
`

export async function login(input) {
    const data = await graphQLRequest(LOGIN_MUTATION, { input })

    return data
}
