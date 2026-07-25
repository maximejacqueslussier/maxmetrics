import { useState } from 'react'
import { formatDateInputValue } from '../../utils/dateInput.js'

export default function UserForm({ mode, initialValues = {}, errors = {}, onSubmit, onReset }) {
    const [isPasswordVisible, setIsPasswordVisible] = useState(false)

    function handleSubmit(event) {
        event.preventDefault()

        const input = Object.fromEntries(new FormData(event.currentTarget).entries())
        
        if (input.dateOfBirth === '') {
            delete input.dateOfBirth
        }

        onSubmit(input)
    }

    const today = new Date().toISOString().slice(0, 10)
    const dateOfBirth = formatDateInputValue(initialValues.dateOfBirth)

    return (
        <>
            <p>Fields marked with * are required.</p>
            {Object.keys(errors).length > 0 && (
                <p role="alert">Please fix the errors below.</p>
            )}
            <form onSubmit={handleSubmit} onReset={onReset}>
                <fieldset>
                    <legend>Account</legend>

                    {mode === 'add' && (
                        <>
                            <label htmlFor="username">Username <span aria-hidden="true">*</span></label>
                            <input type="text"
                                id="username"
                                name="username"
                                aria-invalid={errors.username ? 'true' : undefined}
                                aria-describedby={errors.username ? 'username-error' : undefined}
                                autoComplete="username"
                                required
                                maxLength="255" />
                            {errors.username && (
                                <p id="username-error">{errors.username}</p>
                            )}

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
                        </>
                    )}

                    <label htmlFor="role">Role</label>
                    <select id="role"
                        name="role"
                        defaultValue={initialValues.role ?? 'ROLE_USER'}>
                        <option value="ROLE_USER">User</option>
                        <option value="ROLE_ADMIN">Administrator</option>
                    </select>
                </fieldset>

                <fieldset>
                    <legend>Name</legend>
                    
                    <label htmlFor="salutation">Salutation</label>
                    <input type="text"
                        id="salutation"
                        name="salutation"
                        aria-invalid={errors.salutation ? 'true' : undefined}
                        aria-describedby={errors.salutation ? 'salutation-error' : undefined}
                        autoComplete="honorific-prefix"
                        maxLength="64"
                        defaultValue={initialValues.salutation} />
                    {errors.salutation && (
                        <p id="salutation-error">{errors.salutation}</p>
                    )}
                    
                    <label htmlFor="firstName">First name <span aria-hidden="true">*</span></label>
                    <input type="text"
                        id="firstName"
                        name="firstName"
                        aria-invalid={errors.firstName ? 'true' : undefined}
                        aria-describedby={errors.firstName ? 'first-name-error' : undefined}
                        autoComplete="given-name"
                        required
                        maxLength="128"
                        defaultValue={initialValues.firstName} />
                    {errors.firstName && (
                        <p id="first-name-error">{errors.firstName}</p>
                    )}
                    
                    <label htmlFor="middleName">Middle name</label>
                    <input type="text"
                        id="middleName"
                        name="middleName"
                        aria-invalid={errors.middleName ? 'true' : undefined}
                        aria-describedby={errors.middleName ? 'middle-name-error' : undefined}
                        autoComplete="additional-name"
                        maxLength="128"
                        defaultValue={initialValues.middleName} />
                    {errors.middleName && (
                        <p id="middle-name-error">{errors.middleName}</p>
                    )}
                    
                    <label htmlFor="lastName">Last name <span aria-hidden="true">*</span></label>
                    <input type="text"
                        id="lastName"
                        name="lastName"
                        aria-invalid={errors.lastName ? 'true' : undefined}
                        aria-describedby={errors.lastName ? 'last-name-error' : undefined}
                        autoComplete="family-name"
                        required
                        maxLength="128"
                        defaultValue={initialValues.lastName} />
                    {errors.lastName && (
                        <p id="last-name-error">{errors.lastName}</p>
                    )}
                </fieldset>
                <fieldset>
                    <legend>Identity</legend>
                    
                    <label htmlFor="pronouns">Pronouns</label>
                    <input type="text"
                        id="pronouns"
                        name="pronouns"
                        aria-invalid={errors.pronouns ? 'true' : undefined}
                        aria-describedby={errors.pronouns ? 'pronouns-error' : undefined}
                        maxLength="64"
                        defaultValue={initialValues.pronouns} />
                    {errors.pronouns && (
                        <p id="pronouns-error">{errors.pronouns}</p>
                    )}
                    
                    <label htmlFor="genderIdentity">Gender Identity</label>
                    <input type="text"
                        id="genderIdentity"
                        name="genderIdentity"
                        aria-invalid={errors.genderIdentity ? 'true' : undefined}
                        aria-describedby={errors.genderIdentity ? 'gender-identity-error' : undefined}
                        maxLength="64"
                        defaultValue={initialValues.genderIdentity} />
                    {errors.genderIdentity && (
                        <p id="gender-identity-error">{errors.genderIdentity}</p>
                    )}

                    <label htmlFor="dateOfBirth">Date of Birth</label>
                    <input type="date"
                        id="dateOfBirth"
                        name="dateOfBirth"
                        aria-invalid={errors.dateOfBirth ? 'true' : undefined}
                        aria-describedby={errors.dateOfBirth ? 'date-of-birth-error' : undefined}
                        max={today}
                        defaultValue={dateOfBirth} />
                    {errors.dateOfBirth && (
                        <p id="date-of-birth-error">{errors.dateOfBirth}</p>
                    )}
                </fieldset>
                <fieldset>
                    <legend>Contact</legend>
                    
                    <label htmlFor="email">Email address <span aria-hidden="true">*</span></label>
                    <input type="email" 
                        id="email"
                        name="email"
                        aria-invalid={errors.email ? 'true' : undefined}
                        aria-describedby={errors.email ? 'email-error' : undefined}
                        autoComplete="email"
                        required
                        maxLength="256"
                        defaultValue={initialValues.email} />
                    {errors.email && (
                        <p id="email-error">{errors.email}</p>
                    )}
                    
                    <label htmlFor="phoneNumber">Phone number</label>
                    <input type="tel"
                        id="phoneNumber"
                        name="phoneNumber"
                        aria-invalid={errors.phoneNumber ? 'true' : undefined}
                        aria-describedby={errors.phoneNumber ? 'phone-number-error' : undefined}
                        autoComplete="tel"
                        maxLength="64"
                        defaultValue={initialValues.phoneNumber} />
                    {errors.phoneNumber && (
                        <p id="phone-number-error">{errors.phoneNumber}</p>
                    )}
                </fieldset>
                
                <button type="submit">
                    {mode === 'edit' ? 'Save changes' : 'Add new user'}
                </button>
                <button type="reset">Reset</button>
            </form>
        </>
    )
}
