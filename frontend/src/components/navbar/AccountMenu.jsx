import { NavLink } from 'react-router'
import { useAuth } from '../../authentication/AuthContext.jsx'

export default function AccountMenu () {
    const { isAuthenticated } = useAuth()

    return (
        <ul>
            {!isAuthenticated && (
                <li>
                    <NavLink to="/login">Login</NavLink>
                </li>
            )}
        </ul>
    )
}