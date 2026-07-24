import { Link, useNavigate } from 'react-router'
import UsernameForm from '../../components/account/UsernameForm.jsx'
import { useState } from 'react'
import { useAuth } from '../../authentication/AuthContext.jsx'
import { GraphQLResponseError } from '../../graphql/responseError.js'
import { updateUsername } from '../../graphql/account.js'

export default function UsernamePage () {
    const [errors, setErrors] = useState({})
    const { user, accessToken, updateUser } = useAuth()
    const navigate = useNavigate()

    async function handleSubmit(input) {
        setErrors({})

        try {
            const updatedUser = await updateUsername(input, accessToken)
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
            <h1>Change username</h1>
            <Link to="/account">Back to account</Link>
            <UsernameForm
                initialValues={user}
                errors={errors}
                onSubmit={handleSubmit}
                onReset={() => setErrors({})} />
        </section>
    )
}
