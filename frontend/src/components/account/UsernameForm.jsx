export default function UsernameForm ({ initialValues = {}, errors = {}, onSubmit, onReset }) {
    
    function handleSubmit(event) {
        event.preventDefault();

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
                    <legend>Current username: {initialValues.username}</legend>
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
                </fieldset>

                <button type="submit">Save username</button>
                <button type="reset">Reset</button>
            </form>
        </>
    )
}
