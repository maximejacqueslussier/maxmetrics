import { NavLink } from 'react-router'

export default function Navbar() {
    return (
        <>
            <ul>
                <li>
                    <NavLink to='/'>Home</NavLink>
                </li>
                <li>
                    <NavLink to='/users'>Users</NavLink>
                </li>
            </ul>
        </>
    )
}