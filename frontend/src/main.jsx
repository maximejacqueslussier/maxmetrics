import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import { createBrowserRouter, RouterProvider } from 'react-router'
import App from './App.jsx'
import HomePage from './pages/HomePage.jsx'
import UsersPage from './pages/UsersPage.jsx'
import UsersAddPage from './pages/users/UsersAddPage.jsx'
import UsersEditPage from './pages/users/UsersEditPage.jsx'

const router = createBrowserRouter([
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
            }
        ],
    },
])

createRoot(document.getElementById('root')).render(
    <StrictMode>
        <RouterProvider router={router} />
    </StrictMode>,
)
