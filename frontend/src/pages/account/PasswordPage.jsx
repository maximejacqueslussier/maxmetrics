import { Link, useNavigate } from 'react-router'
import PasswordForm from '../../components/account/PasswordForm.jsx'
import { GraphQLResponseError } from '../../graphql/responseError.js'
import { updatePassword } from '../../graphql/account.js'
import { useAuth } from '../../authentication/AuthContext.jsx'
import { useState } from 'react'

export default function PasswordPage () {
    const [errors, setErrors] = useState({})
    const { accessToken } = useAuth()
    const navigate = useNavigate()

    async function handleSubmit(input) {
        setErrors({})

        try {
            await updatePassword(input, accessToken)
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
            <h1>Change password</h1>
            <Link to="/account">Back to account</Link>
            <PasswordForm
                errors={errors}
                onSubmit={handleSubmit}
                onReset={() => setErrors({})} />
        </section>
    )
}
