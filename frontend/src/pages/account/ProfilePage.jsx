import { Link, useNavigate } from 'react-router'
import ProfileForm from '../../components/account/ProfileForm'
import { useState } from 'react'
import { useAuth } from '../../authentication/AuthContext'
import { GraphQLResponseError } from '../../graphql/responseError'
import { updateProfile } from '../../graphql/account'

export default function ProfilePage () {
    const [errors, setErrors] = useState({})
    const { user, accessToken, updateUser } = useAuth()
    const navigate = useNavigate()

    async function handleSubmit(input) {
        setErrors({})

        try {
            const updatedUser = await updateProfile(input, accessToken)
            updateUser(updatedUser)
            navigate('/account')
        } catch (error) {
            if (error instanceof GraphQLResponseError) {
                setErrors(error.getFieldErrors())

                return
            }
        }
    }

    return (
        <section>
            <h1>Update profile</h1>
            <Link to="/account">Back to account</Link>
            <ProfileForm 
                initialValues={user}
                errors={errors}
                onSubmit={handleSubmit}
                onReset={() => setErrors({})} />
        </section>
    )
}
