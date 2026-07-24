import { Link } from 'react-router'
import { useAuth } from '../authentication/AuthContext.jsx'

export default function AccountPage () {
    const { user } = useAuth()

    const fullName = [
        user.firstName,
        user.middleName,
        user.lastName,
    ].filter(Boolean).join(' ')

    const phoneNumber = user.phoneNumber?.trim()
    const salutation = user.salutation?.trim()
    const pronouns = user.pronouns?.trim()
    const genderIdentity = user.genderIdentity?.trim()

    return (
        <>
            <h1>Account</h1>

            <section aria-labelledby="sign-in-heading">
                <h2 id="sign-in-heading">Sign-in details</h2>
                <dl>
                    <dt>
                        Username <Link to="username">Update</Link>
                    </dt>
                    <dd>{user.username}</dd>

                    <dt>
                        Password <Link to="password">Update</Link>
                    </dt>
                    <dd>****</dd>


                    <dt>
                        Email <Link to="email">Update</Link>
                    </dt>
                    <dd>{user.email}</dd>

                    <dt>Role</dt>
                    <dd>{user.role}</dd>
                </dl>
            </section>

            <section aria-labelledby="profile-heading">
                <h2 id="profile-heading">Profile</h2>
                <Link to="profile">Update profile</Link>

                <dl>
                    <dt>Name</dt>
                    <dd>{fullName}</dd>

                    {phoneNumber && (
                        <>
                            <dt>Phone number</dt>
                            <dd>{phoneNumber}</dd>
                        </>
                    )}

                    {salutation && (
                        <>
                            <dt>Salutation</dt>
                            <dd>{salutation}</dd>
                        </>
                    )}
                    {pronouns && (
                        <>
                            <dt>Pronouns</dt>
                            <dd>{pronouns}</dd>
                        </>
                    )}
                    {genderIdentity && (
                        <>
                            <dt>Gender identity</dt>
                            <dd>{genderIdentity}</dd>
                        </>
                    )}
                </dl>
            </section>
        </>
    )
}
