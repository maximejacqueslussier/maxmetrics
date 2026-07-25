import { graphQLRequest } from './request.js'

const LIST_USERS_QUERY = `
    query ListUsers(
        $first: Int
        $after: String
        $orderBy: [UserOrderByInput!]
        $filter: UserFilterInput
    ) {
        users (
            first: $first
            after: $after
            orderBy: $orderBy
            filter: $filter
        ) {
            edges {
                node {
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
                    dateOfBirth
                    createdAt
                    updatedAt
                }
            }
            pageInfo {
                hasPreviousPage
                hasNextPage
                startCursor
                endCursor
            }
        }
    }
`

const GET_USER_QUERY = `
    query GetUser($id: ID!) {
        users(
            first: 1,
            filter: { ids: [$id] }
        ) {
            edges {
                node {
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
                    dateOfBirth
                    createdAt
                    updatedAt
                }
            }
        }
    }
`

const CREATE_USER_MUTATION = `
    mutation CreateUser($input: CreateUserInput!) {
        createUser(input: $input) {
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
                dateOfBirth
                createdAt
                updatedAt
            }
        }
    }
`

const UPDATE_USER_MUTATION = `
    mutation UpdateUser($id: ID!, $input: UpdateUserInput!) {
        updateUser(id: $id, input: $input) {
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
                dateOfBirth
                createdAt
                updatedAt
            }
            changedFields
        }
    }
`

const DELETE_USER_MUTATION = `
    mutation DeleteUser($id: ID!) {
        deleteUser(id: $id) {
            deletedUserId
        }
    }
`

export async function listUsers(accessToken, options = {}) {
    const {
        first = 20,
        after = null,
        orderBy = { field: 'ID', direction: 'ASC' },
        filter = null,
    } = options

    const variables = Object.fromEntries(Object.entries({
        first,
        after,
        orderBy: Array.isArray(orderBy) ? orderBy : [orderBy],
        filter,
    }).filter(([, value]) => value !== null))

    const data = await graphQLRequest(LIST_USERS_QUERY, variables, accessToken)

    return {
        users: data.users.edges.map(edge => edge.node),
        pageInfo: data.users.pageInfo,
    }
}

export async function getUser(accessToken, id) {
    const data = await graphQLRequest(GET_USER_QUERY, { id }, accessToken)

    return data.users.edges[0]?.node
}

export async function createUser(accessToken, input) {
    const data = await graphQLRequest(CREATE_USER_MUTATION, { input }, accessToken)
    
    return data.createUser.user
}

export async function updateUser(accessToken, id, input) {
    const data = await graphQLRequest(UPDATE_USER_MUTATION, { id, input }, accessToken)

    return data.updateUser.user
}

export async function deleteUser(accessToken, id) {
    const data = await graphQLRequest(DELETE_USER_MUTATION, { id }, accessToken)

    return data.deleteUser.deletedUserId
}
