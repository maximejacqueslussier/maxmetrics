import { useNavigate } from 'react-router'
import { useState } from 'react'
import { useAuth } from '../../authentication/AuthContext.jsx'
import { GraphQLResponseError } from '../../graphql/responseError.js'

export default function LoginForm () {
    const navigate = useNavigate()
    const { login } = useAuth()
    const [error, setError] = useState('')
    const [isPasswordVisible, setIsPasswordVisible] = useState(false)

    async function handleSubmit(event) {
        event.preventDefault()

        setError('')
        const input = Object.fromEntries(new FormData(event.currentTarget).entries())

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
        <>
            {error.length > 0 && (
                <p role="alert" tabIndex="-1">{error}</p>
            )}
            <form onSubmit={handleSubmit} onReset={() => setError('')}>
                <fieldset>
                    <legend>Login</legend>
                    <label htmlFor="username">Username</label>
                    <input type="text"
                        id="username"
                        name="username"
                        autoComplete="username"
                        maxLength="255" />

                    <label htmlFor="password">Password</label>
                    <input type={isPasswordVisible ? 'text' : 'password'}
                        id="password"
                        name="password"
                        autoComplete="current-password"
                        maxLength="255" />
                    <button type="button"
                        aria-controls="password"
                        onClick={() => setIsPasswordVisible((visible) => !visible)}>
                        {isPasswordVisible ? 'Hide password' : 'Show password'}
                    </button>

                    <button type="submit">Login</button>
                    <button type="reset">Reset</button>
                </fieldset>
            </form>
        </>
    )
}
