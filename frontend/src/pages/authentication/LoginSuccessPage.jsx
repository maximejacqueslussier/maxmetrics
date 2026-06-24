import { useEffect, useState } from 'react'
import { useLocation, useNavigate } from 'react-router'

export default function LoginSuccessPage () {
    const navigate = useNavigate()
    const location = useLocation()
    const [seconds, setSeconds] = useState(5)

    useEffect(() => {
        if (seconds === 1) {
            navigate(location.state?.destination ?? '/', { replace: true })

            return
        }

        const timer = setTimeout(() => {
            setSeconds((current) => current-1)
        }, 1000)

        return () => clearTimeout(timer)
    })

    return (
        <section>
            <h1>You have logged in successfully</h1>
            <p>You will be redirected in {seconds}...</p>
        </section>
    )
}