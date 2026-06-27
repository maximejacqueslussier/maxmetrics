import { NavLink } from 'react-router'
import { useAuth } from '../../authentication/AuthContext.jsx'

export default function NavigationMenu () {
    const { isAdmin } = useAuth()

    return (
        <>
            <ul>
                <li>
                    <NavLink to='/'>Home</NavLink>
                </li>
                {isAdmin && (
                    <li>
                        <NavLink to='/users'>Users</NavLink>
                    </li>
                )}
            </ul>
        </>
    )
}