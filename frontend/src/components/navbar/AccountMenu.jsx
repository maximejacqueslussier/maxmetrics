import { NavLink } from 'react-router'
import { useAuth } from '../../authentication/AuthContext.jsx'

export default function AccountMenu () {
    const { isAuthenticated, logout } = useAuth()

    return (
        <ul>
            {!isAuthenticated && (
                <li>
                    <NavLink to="/login">Login</NavLink>
                </li>
            )}

            {isAuthenticated && (
                <li>
                    <button type="button" onClick={logout}>
                        Logout
                    </button>
                </li>
            )}
        </ul>
    )
}