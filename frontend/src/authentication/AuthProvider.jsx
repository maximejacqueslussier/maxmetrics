import { useCallback, useMemo, useState } from 'react'
import { login as loginMutation } from '../graphql/authentication.js'
import { AuthContext } from './AuthContext.jsx'

export function AuthProvider ({ children }) {
    const [state, setState] = useState({
        status: 'anonymous',
        user: null,
        accessToken: null,
    })

    const login = useCallback(async (credentials) => {
        const { login } = await loginMutation(credentials)

        setState({
            status: 'authenticated',
            user: login.user,
            accessToken: login.accessToken,
        })
    }, [])

    const logout = useCallback(() => {
        setState({
            status: 'anonymous',
            user: null,
            accessToken: null,
        })
    }, [])

    const value = useMemo(() => ({
        ...state,
        isAuthenticated: state.status === 'authenticated',
        isAdmin: state.status === 'authenticated' && state.user?.role === 'ROLE_ADMIN',
        login,
        logout,
    }), [state, login, logout])

    return (
        <AuthContext.Provider value={value}>
            {children}
        </AuthContext.Provider>
    )
}
