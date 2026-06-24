import { Link, useNavigate, useParams } from 'react-router'
import { useEffect, useState } from 'react'
import UserForm from '../../components/users/UserForm.jsx'
import { getUser, updateUser } from '../../graphql/users.js'
import { GraphQLResponseError } from '../../graphql/responseError.js'

export default function UsersEditPage() {
    const { id } = useParams()
    const navigate = useNavigate()
    const [user, setUser] = useState(null)
    const [isLoading, setIsLoading] = useState(true)
    const [errors, setErrors] = useState({})

    useEffect(() => {
        async function loadUser() {
            setIsLoading(true)
            setUser(await getUser(id))
            setIsLoading(false)
        }

        document.title = `Edit user ${id} | Users | MaxFit`
        loadUser()
    }, [id])
    
    async function handleSubmit(input) {
        setErrors({})
        
        try {
            await updateUser(id, input)
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
            <h1>Edit user {id}</h1>
            <Link to="/users">Back to users</Link>

            {isLoading ? (
                <p role="status" aria-live="polite">Loading user data...</p>
            ) : (
                <UserForm
                    mode="edit"
                    initialValues={user}
                    errors={errors}
                    onSubmit={handleSubmit}
                    onReset={() => setErrors({})}
                />
            )}
        </section>
    )
}
