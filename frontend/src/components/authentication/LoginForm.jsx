import { Link, useNavigate } from 'react-router'
import { useState } from 'react'
import { GraphQLResponseError } from '../../graphql/responseError.js'

export default function LoginForm () {
    const navigate = useNavigate()
    const [errors, setErrors] = useState({})
    const [isPasswordVisible, setIsPasswordVisible] = useState(false)

    async function handleSubmit(event) {
        event.preventDefault()

        setErrors({})
        const input = Object.fromEntries(new FormData(event.currentTarget).entries())

        try {
            await login(input)
            navigate('/login/success', {
                replace: true,
                state: { destination: '/' },
            })
        } catch (error) {
            if (error instanceof GraphQLResponseError) {
                setErrors(error.getFieldErrors())
            
                return
            }
        }
    }

    return (
        <>
            {Object.keys(errors).length > 0 && (
                <p role="alert">Please fix the errors below.</p>
            )}
            <form onSubmit={handleSubmit} onReset={() => setErrors({})}>
                <fieldset>
                    <legend>Login</legend>
                    <label htmlFor="username">Username</label>
                    <input type="text"
                        id="username"
                        aria-invalid={errors.username ? 'true' : undefined}
                        aria-describedby={errors.username ? 'usernameError' : undefined}
                        autoComplete="username"
                        maxLength="255" />
                    {errors.username && (
                        <p id="usernameError">{errors.username}</p>
                    )}

                    <label htmlFor="password">Password</label>
                    <input type={isPasswordVisible ? 'text' : 'password'}
                        id="password"
                        name="password"
                        aria-invalid={errors.password ? 'true' : undefined}
                        aria-describedby={errors.password ? 'passwordError' : undefined}
                        autoComplete="off"
                        maxLength="255" />
                    <button type="button"
                        aria-controls="password"
                        onClick={() => setIsPasswordVisible((visible) => !visible)}>
                        {isPasswordVisible ? 'Hide password' : 'Show password'}
                    </button>
                    {errors.password && (
                        <p id="passwordError">{errors.password}</p>
                    )}

                    <button type="submit">Login</button>
                    <button type="reset">Reset</button>
                </fieldset>
            </form>
        </>
    )
}