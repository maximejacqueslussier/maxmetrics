import { graphQLRequest } from './request.js'

const LOGIN_MUTATION = `
    mutation Login($input: LoginInput!) {
        login(input: $input) {
            accessToken
        }
    }
`

const REFRESH_TOKEN_MUTATION = `
    mutation RefreshToken {
        refreshToken {
            accessToken
        }
    }
`

const LOGOUT_MUTATION = `
    mutation Logout {
        logout {
            success
        }
    }
`

const ME_QUERY = `
    query Me {
        me {
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
    }
`

export async function login(input) {
    const data = await graphQLRequest(LOGIN_MUTATION, { input })

    return data
}

export async function refreshToken() {
    const data = await graphQLRequest(REFRESH_TOKEN_MUTATION)

    return data
}

export async function logout() {
    const data = await graphQLRequest(LOGOUT_MUTATION)

    return data
}

export async function me(accessToken) {
    const data = await graphQLRequest(ME_QUERY, {}, accessToken)

    return data
}