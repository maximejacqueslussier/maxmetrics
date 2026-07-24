import { useState } from 'react'

export default function PasswordForm ({ errors = {}, onSubmit, onReset }) {
    const [isPasswordVisible, setIsPasswordVisible] = useState(false)

    function handleSubmit(event) {
        event.preventDefault()

        const input = Object.fromEntries(new FormData(event.currentTarget).entries())
        
        onSubmit(input)
    }

    return (
        <>
            <p>Fields marked with * are required.</p>
            {Object.keys(errors).length > 0 && (
                <p role="alert">Please fix the errors below.</p>
            )}
            <form onSubmit={handleSubmit} onReset={onReset}>
                <fieldset>
                    <legend>Current password: ****</legend>
                    <label htmlFor="password">Password <span aria-hidden="true">*</span></label>
                    <input type={isPasswordVisible ? 'text' : 'password'}
                        id="password"
                        name="password"
                        aria-invalid={errors.password ? 'true' : undefined}
                        aria-describedby={errors.password ? 'password-error' : undefined}
                        autoComplete="off"
                        required
                        maxLength="255" />
                    <button type="button"
                        aria-controls="password"
                        onClick={() => setIsPasswordVisible((visible) => !visible)}>
                        {isPasswordVisible ? 'Hide password' : 'Show password'}
                    </button>
                    {errors.password && (
                        <p id="password-error">{errors.password}</p>
                    )}
                </fieldset>

                <button type="submit">Save password</button>
                <button type="reset">Reset</button>
            </form>
        </>
    )
}