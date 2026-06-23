import { Link, useNavigate } from 'react-router'
import UserForm from '../../components/users/UserForm.jsx'
import { createUser } from '../../graphql/users.js'

export default function UsersAddPage() {
    const navigate = useNavigate()
    
    async function handleSubmit(event) {
        event.preventDefault()
        
        const formData = new FormData(event.currentTarget)
        const input = {
            username: formData.get('username'),
            password: formData.get('password'),
            role: formData.get('role'),
            salutation: formData.get('salutation'),
            firstName: formData.get('firstName'),
            middleName: formData.get('middleName'),
            lastName: formData.get('lastName'),
            pronouns: formData.get('pronouns'),
            genderIdentity: formData.get('genderIdentity'),
            email: formData.get('email'),
            phoneNumber: formData.get('phoneNumber'),
        }
        
        await createUser(input)
        navigate('/users')
    }
    
    return (
        <section>
            <h1>Add a new user</h1>
            <Link to="/users">Back to users</Link>
            <UserForm mode="add" onSubmit={handleSubmit} />
        </section>
    )
}
