import { useState } from 'react'
import { Link, useNavigate } from 'react-router'
import UserForm from '../../components/users/UserForm.jsx'
import { createUser } from '../../graphql/users.js'
import { GraphQLResponseError } from '../../graphql/responseError.js'

export default function UsersAddPage() {
    const navigate = useNavigate()
    const [errors, setErrors] = useState({})
    
    async function handleSubmit(input) {
        setErrors({})
        
        try {
            await createUser(input)
            navigate('/users')
        } catch (error) {
            if (error instanceof GraphQLResponseError) {
                setErrors(error.getFieldErrors())

                return
            }
        }
    }
    
    return (
        <section>
            <h1>Add a new user</h1>
            <Link to="/users">Back to users</Link>
            <UserForm
                mode="add"
                errors={errors}
                onSubmit={handleSubmit}
                onReset={() => setErrors({})}
            />
        </section>
    )
}
