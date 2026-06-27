import { useEffect } from 'react'
import { Outlet, useMatches } from 'react-router'
import Footer from './components/footer/Footer'
import Header from './components/header/Header'
import NavigationMenu from './components/navbar/NavigationMenu'
import AccountMenu from './components/navbar/AccountMenu'

export default function App() {
    const matches = useMatches()
    const currentTitle = [...matches].reverse().find(match => match.handle?.pageTitle)?.handle.pageTitle ?? 'MaxMetrics'

    useEffect(() => {
        document.title = currentTitle
    }, [currentTitle])
    
    return (
        <>
            <a href="#main-content">Skip to content</a>
            <header>
                <Header />
                <nav aria-label="Primary">
                    <NavigationMenu />
                </nav>
                <nav aria-label="Account">
                    <AccountMenu />
                </nav>
            </header>
            <main id="main-content">
                <Outlet />
            </main>
            <footer>
                <Footer />
            </footer>
        </>
    )
}