export default function EmailForm ({ initialValues = {}, errors = {}, onSubmit, onReset }) {
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
                    <legend>Current email: {initialValues.email}</legend>
                    <label htmlFor="email">Email <span aria-hidden="true">*</span></label>
                    <input type="email"
                        id="email"
                        name="email"
                        aria-invalid={errors.email ? 'true' : undefined}
                        aria-describedby={errors.email ? 'email-error' : undefined}
                        autoComplete="email"
                        required
                        maxLength="255" />
                    {errors.email && (
                        <p id="email-error">{errors.email}</p>
                    )}
                </fieldset>

                <button type="submit">Save email</button>
                <button type="reset">Reset</button>
            </form>
        </>
    )
}