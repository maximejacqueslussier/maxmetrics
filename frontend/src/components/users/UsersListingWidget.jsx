import { useState, useEffect } from 'react'
import { Link } from 'react-router'
import { deleteUser, listUsers } from '../../graphql/users.js'
import DeleteUserDialog from './DeleteUserDialog.jsx'
import { useAuth } from '../../authentication/AuthContext.jsx'

export default function UsersListingWidget() {
    const [users, setUsers] = useState([])
    const [selectedUser, setSelectedUser] = useState(null)
    const { accessToken } = useAuth()
    
    useEffect(() => {
        async function loadUsers() {
            const result = await listUsers(accessToken)
            setUsers(result.users)
        }
        
        loadUsers()
    }, [accessToken])
    
    return (
        <>
            <table>
                <caption>Users list</caption>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope='col'>Username</th>
                        <th scope="col">Role</th>
                        <th scope="col">Salutation</th>
                        <th scope="col">Pronouns</th>
                        <th scope="col">Gender identity</th>
                        <th scope="col">Date of birth</th>
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col">Email address</th>
                        <th scope="col">Phone number</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Updated at</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {users.map(user => (
                        <tr key={user.id}>
                            <td>{user.id}</td>
                            <td>{user.username}</td>
                            <td>{user.role}</td>
                            <td>{user.salutation}</td>
                            <td>{user.pronouns}</td>
                            <td>{user.genderIdentity}</td>
                            <td>{user.dateOfBirth}</td>
                            <td>{user.firstName}</td>
                            <td>{user.lastName}</td>
                            <td>{user.email}</td>
                            <td>{user.phoneNumber}</td>
                            <td>{user.createdAt}</td>
                            <td>{user.updatedAt}</td>
                            <td>
                                <Link to={`/users/${user.id}/edit`}>Edit</Link>
                                <button type="button" onClick={() => setSelectedUser(user)}>Delete</button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
            <DeleteUserDialog
                user={selectedUser}
                onCancel={() => setSelectedUser(null)}
                onConfirm={async (id) => {
                    await deleteUser(accessToken, id)
                    setUsers(currentUsers => currentUsers.filter(user => user.id !== id))
                    setSelectedUser(null)
                }} />
        </>
    )
}
