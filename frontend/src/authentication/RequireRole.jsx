import { Navigate, Outlet, useLocation } from 'react-router'
import { useAuth } from './AuthContext.jsx'

function RequireRole ({ requiredRole }) {
    const { status, user } = useAuth()
    const location = useLocation()

    if (status !== 'authenticated') {
        return (
            <Navigate to="/login" replace state={{ destination: location.pathname }} />
        )
    }

    if (user.role !== 'ROLE_ADMIN' && user.role !== requiredRole) {
        return (
            <Navigate to="/" replace />
        )
    }

    return <Outlet />
}

export function RequireAdmin () {
    return <RequireRole requiredRole="ROLE_ADMIN" />
}

export function RequireUser () {
    return <RequireRole requiredRole="ROLE_USER" />
}
