import { useCallback, useEffect, useMemo, useRef, useState } from 'react'
import { login as loginMutation, refreshToken as refreshTokenMutation, logout as logoutMutation, me as meQuery } from '../graphql/authentication.js'
import { AuthContext } from './AuthContext.jsx'

export function AuthProvider ({ children }) {
    const [state, setState] = useState({
        status: 'loading',
        user: null,
        accessToken: null,
    })

    const didRestoreSession = useRef(false)

    useEffect(() => {
        if (didRestoreSession.current) {
            return
        }

        didRestoreSession.current = true

        async function restoreSession() {
            try {
                const { refreshToken } = await refreshTokenMutation()
                const { me } = await meQuery(refreshToken.accessToken)

                setState({
                    status: 'authenticated',
                    user: me,
                    accessToken: refreshToken.accessToken,
                })
            } catch {
                setState({
                    status: 'anonymous',
                    user: null,
                    accessToken: null,
                })
            }
        }

        restoreSession()
    }, [])

    const login = useCallback(async (credentials) => {
        const { login } = await loginMutation(credentials)
        const { me } = await meQuery(login.accessToken)

        setState({
            status: 'authenticated',
            user: me,
            accessToken: login.accessToken,
        })
    }, [])

    const logout = useCallback(async () => {
        const { logout } = await logoutMutation()

        if (logout.success) {
            setState({
                status: 'anonymous',
                user: null,
                accessToken: null,
            })
        }
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
