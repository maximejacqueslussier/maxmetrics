import { useState } from 'react'
import LoginForm from '../../components/authentication/LoginForm.jsx'
import { useAuth } from '../../authentication/AuthContext.jsx'
import { useNavigate } from 'react-router'
import { GraphQLResponseError } from '../../graphql/responseError.js'

export default function LoginPage () {
    const [error, setError] = useState('')
    const { login } = useAuth()
    const navigate = useNavigate()

    async function handleSubmit(input) {
        setError('')

        try {
            await login(input)
            navigate('/')
        } catch (error) {
            if (error instanceof GraphQLResponseError) {
                setError(error.errors[0]?.message)
            
                return
            }

            setError('Unable to log in. Please try again.')
        }
    }

    return (
        <section>
            <h1>Login</h1>
            <LoginForm 
                error={error}
                onSubmit={handleSubmit}
                onReset={() => setError('') }/>
        </section>
    )
}