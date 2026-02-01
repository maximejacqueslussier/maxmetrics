import { useEffect } from 'react'
import { Outlet, useMatches } from 'react-router'
import Footer from './components/footer/Footer'
import Header from './components/header/Header'
import Navbar from './components/navbar/Navbar'

export default function App() {
    const matches = useMatches()
    const currentTitle = [...matches].reverse().find(match => match.handle?.pageTitle)?.handle.pageTitle ?? 'MaxFit'

    useEffect(() => {
        document.title = currentTitle
    }, [currentTitle])
    
    return (
        <>
            <a href="#main-content">Skip to content</a>
            <header>
                <Header />
                <nav aria-label="Primary">
                    <Navbar />
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