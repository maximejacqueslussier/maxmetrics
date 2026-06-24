import { createBrowserRouter } from 'react-router'
import App from './App.jsx'
import HomePage from './pages/HomePage.jsx'
import UsersPage from './pages/UsersPage.jsx'
import UsersAddPage from './pages/users/UsersAddPage.jsx'
import UsersEditPage from './pages/users/UsersEditPage.jsx'
import LoginPage from './pages/authentication/LoginPage.jsx'
import LoginSuccessPage from './pages/authentication/LoginSuccessPage.jsx'

export const router = createBrowserRouter([
    {
        path: '/',
        Component: App,
        handle: { pageTitle: 'MaxFit' },
        children: [
            {
                index: true,
                Component: HomePage,
                handle: { pageTitle: 'Home | MaxFit' }
            },
            {
                path: 'users',
                Component: UsersPage,
                handle: { pageTitle: 'Users | MaxFit' }
            },
            {
                path: 'users/add',
                Component: UsersAddPage,
                handle: { pageTitle: 'Add a new user | Users | MaxFit' }
            },
            {
                path: 'users/:id/edit',
                Component: UsersEditPage,
                handle: { pageTitle: 'Edit user | Users | MaxFit' }
            },
            {
                path: '/login',
                Component: LoginPage,
                handle: { pageTitle: 'Login | MaxFit' }
            },
            {
                path: '/login/success',
                Component: LoginSuccessPage,
                handle: { pageTitle: 'Login successful | MaxFit' }
            }
        ],
    },
])