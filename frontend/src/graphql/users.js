import { graphqlRequest } from './request.js'

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
                    salutation
                    pronouns
                    genderIdentity
                    firstName
                    middleName
                    lastName
                    email
                    phoneNumber
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
                    salutation
                    pronouns
                    genderIdentity
                    firstName
                    middleName
                    lastName
                    email
                    phoneNumber
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
                salutation
                pronouns
                genderIdentity
                firstName
                middleName
                lastName
                email
                phoneNumber
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
                salutation
                pronouns
                genderIdentity
                firstName
                middleName
                lastName
                email
                phoneNumber
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

export async function listUsers(options = {}) {
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

    const data = await graphqlRequest(LIST_USERS_QUERY, variables)

    return {
        users: data.users.edges.map(edge => edge.node),
        pageInfo: data.users.pageInfo,
    }
}

export async function getUser(id) {
    const data = await graphqlRequest(GET_USER_QUERY, { id })

    return data.users.edges[0]?.node
}

export async function createUser(input) {
    const data = await graphqlRequest(CREATE_USER_MUTATION, { input })
    
    return data.createUser.user
}

export async function updateUser(id, input) {
    const data = await graphqlRequest(UPDATE_USER_MUTATION, { id, input })

    return data.updateUser.user
}

export async function deleteUser(id) {
    const data = await graphqlRequest(DELETE_USER_MUTATION, { id })

    return data.deleteUser.deletedUserId
}