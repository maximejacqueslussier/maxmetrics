import { Link, useNavigate } from 'react-router'
import EmailForm from '../../components/account/EmailForm.jsx'
import { useState } from 'react'
import { GraphQLResponseError } from '../../graphql/responseError.js'
import { updateEmail } from '../../graphql/account.js'
import { useAuth } from '../../authentication/AuthContext.jsx'

export default function EmailPage () {
    const [errors, setErrors] = useState({})
    const { user, accessToken, updateUser } = useAuth()
    const navigate = useNavigate()

    async function handleSubmit(input) {
        setErrors({})

        try {
            const updatedUser = await updateEmail(input, accessToken)
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
            <h1>Change email</h1>
            <Link to="/account">Back to account</Link>
            <EmailForm
                initialValues={user}
                errors={errors}
                onSubmit={handleSubmit}
                onReset={() => setErrors({})} />
        </section>
    )
}