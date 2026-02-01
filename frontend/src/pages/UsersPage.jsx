import UsersListingWidget from '../components/users/UsersListingWidget'
import { Link } from 'react-router'

export default function UsersPage() {
    return (
        <section>
            <h1>Users</h1>
            <Link to="add">Add a new user</Link>
            <UsersListingWidget />
        </section>
    )
}
