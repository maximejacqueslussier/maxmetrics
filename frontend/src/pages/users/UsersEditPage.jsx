import { Link, useNavigate, useParams } from 'react-router'
import { useEffect, useState } from 'react'
import UserForm from '../../components/users/UserForm.jsx'
import { getUser, updateUser } from '../../graphql/users.js'

export default function UsersEditPage() {
    const { id } = useParams()
    const navigate = useNavigate()
    const [user, setUser] = useState(null)
    const [isLoading, setIsLoading] = useState(true)

    useEffect(() => {
        async function loadUser() {
            setIsLoading(true)
            setUser(await getUser(id))
            setIsLoading(false)
        }

        document.title = `Edit user ${id} | Users | MaxFit`
        loadUser()
    }, [id])
    
    async function handleSubmit(event) {
        event.preventDefault()
        
        const formData = new FormData(event.currentTarget)
        const input = {
            salutation: formData.get('salutation'),
            firstName: formData.get('firstName'),
            middleName: formData.get('middleName'),
            lastName: formData.get('lastName'),
            pronouns: formData.get('pronouns'),
            genderIdentity: formData.get('genderIdentity'),
            email: formData.get('email'),
            phoneNumber: formData.get('phoneNumber'),
        }
        
        await updateUser(id, input)
        navigate('/users')
    }
    
    return (
        <section>
            <h1>Edit user {id}</h1>
            <Link to="/users">Back to users</Link>

            {isLoading ? (
                <p role="status" aria-live="polite">Loading user data...</p>
            ) : (
                <UserForm mode="edit" initialValues={user} onSubmit={handleSubmit} />
            )}
        </section>
    )
}
