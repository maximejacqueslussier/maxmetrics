import { createBrowserRouter } from 'react-router'
import App from './App.jsx'
import AccountPage from './pages/AccountPage.jsx'
import HomePage from './pages/HomePage.jsx'
import UsersPage from './pages/UsersPage.jsx'
import UsersAddPage from './pages/users/UsersAddPage.jsx'
import UsersEditPage from './pages/users/UsersEditPage.jsx'
import LoginPage from './pages/authentication/LoginPage.jsx'
import { RequireAdmin, RequireUser } from './authentication/RequireRole.jsx'
import UsernamePage from './pages/account/UsernamePage.jsx'
import EmailPage from './pages/account/EmailPage.jsx'
import PasswordPage from './pages/account/PasswordPage.jsx'
import ProfilePage from './pages/account/ProfilePage.jsx'

export const router = createBrowserRouter([
    {
        path: '/',
        Component: App,
        handle: { pageTitle: 'MaxMetrics' },
        children: [
            {
                index: true,
                Component: HomePage,
                handle: { pageTitle: 'Home | MaxMetrics' }
            },
            {
                path: 'login',
                Component: LoginPage,
                handle: { pageTitle: 'Login | MaxMetrics' }
            },
            {
                Component: RequireUser,
                children: [
                    {
                        path: 'account',
                        Component: AccountPage,
                        handle: { pageTitle: 'Account | MaxMetrics' }
                    },
                    {
                        path: 'account/username',
                        Component: UsernamePage,
                        handle: { pageTitle: 'Change username | MaxMetrics' }
                    },
                    {
                        path: 'account/email',
                        Component: EmailPage,
                        handle: { pageTitle: 'Change email | MaxMetrics' }
                    },
                    {
                        path: 'account/password',
                        Component: PasswordPage,
                        handle: { pageTitle: 'Change password | MaxMetrics' }
                    },
                    {
                        path: 'account/profile',
                        Component: ProfilePage,
                        handle: { pageTitle: 'Update profile | MaxMetrics' }
                    }
                ],
            },
            {
                Component: RequireAdmin,
                children: [
                    {
                        path: 'users',
                        Component: UsersPage,
                        handle: { pageTitle: 'Users | MaxMetrics' }
                    },
                    {
                        path: 'users/add',
                        Component: UsersAddPage,
                        handle: { pageTitle: 'Add a new user | Users | MaxMetrics' }
                    },
                    {
                        path: 'users/:id/edit',
                        Component: UsersEditPage,
                        handle: { pageTitle: 'Edit user | Users | MaxMetrics' }
                    },
                ],
            }
        ],
    },
])