import { graphQLRequest } from './request.js'

const UPDATE_USERNAME_MUTATION = `
    mutation UpdateUsername($input: UpdateUsernameInput!) {
	    updateUsername(input: $input) {
		    user {
			    username
		    }
	    }
    }
`

const UPDATE_EMAIL_MUTATION = `
	mutation UpdateEmail($input: UpdateEmailInput!) {
		updateEmail(input: $input) {
			user {
				email
			}
		}
	}
`

const UPDATE_PASSWORD_MUTATION = `
	mutation UpdatePassword($input: UpdatePasswordInput!) {
		updatePassword(input: $input) {
			success
		}
	}
`

const UPDATE_PROFILE_MUTATION = `
	mutation UpdateProfile($input: UpdateProfileInput!) {
		updateProfile(input: $input) {
			user {
				salutation
				pronouns
				genderIdentity
				phoneNumber
			}
		}
	}
`

export async function updateUsername(input, accessToken)
{
    const data = await graphQLRequest(UPDATE_USERNAME_MUTATION, { input }, accessToken)

    return data.updateUsername.user
}

export async function updateEmail(input, accessToken)
{
    const data = await graphQLRequest(UPDATE_EMAIL_MUTATION, { input }, accessToken)

    return data.updateEmail.user
}

export async function updatePassword(input, accessToken)
{
    const data = await graphQLRequest(UPDATE_PASSWORD_MUTATION, { input }, accessToken)

    return data.updatePassword.success
}

export async function updateProfile(input, accessToken)
{
    const data = await graphQLRequest(UPDATE_PROFILE_MUTATION, { input }, accessToken)

    return data.updateProfile.user
}