export default function ProfileForm ({ initialValues = {}, errors = {}, onSubmit, onReset }) {
    function handleSubmit(event) {
        event.preventDefault()

        const input = Object.fromEntries(new FormData(event.currentTarget).entries())

        onSubmit(input)
    }

    return (
        <>
            {Object.keys(errors).length > 0 && (
                <p role="alert">Please fix the errors below.</p>
            )}
            <form onSubmit={handleSubmit} onReset={onReset}>
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
                </fieldset>

                <fieldset>
                    <legend>Contact</legend>

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

                <button type="submit">Save profile</button>
                <button type="reset">Reset</button>
            </form>
        </>
    )
}