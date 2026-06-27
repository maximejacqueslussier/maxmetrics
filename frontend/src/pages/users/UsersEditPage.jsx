import { Link, useNavigate, useParams } from 'react-router'
import { useEffect, useState } from 'react'
import UserForm from '../../components/users/UserForm.jsx'
import { getUser, updateUser } from '../../graphql/users.js'
import { GraphQLResponseError } from '../../graphql/responseError.js'
import { useAuth } from '../../authentication/AuthContext.jsx'

export default function UsersEditPage() {
    const { id } = useParams()
    const navigate = useNavigate()
    const { accessToken } = useAuth()
    const [user, setUser] = useState(null)
    const [isLoading, setIsLoading] = useState(true)
    const [errors, setErrors] = useState({})

    useEffect(() => {
        async function loadUser() {
            setIsLoading(true)
            setUser(await getUser(accessToken, id))
            setIsLoading(false)
        }

        document.title = `Edit user ${id} | Users | MaxMetrics`
        loadUser()
    }, [accessToken, id])
    
    async function handleSubmit(input) {
        setErrors({})
        
        try {
            await updateUser(accessToken, id, input)
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
