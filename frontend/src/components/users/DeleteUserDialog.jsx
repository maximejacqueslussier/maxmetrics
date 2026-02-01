import { useEffect, useRef } from "react"

export default function DeleteUserDialog({ user, onCancel, onConfirm }) {
    const dialogRef = useRef(null)

    useEffect(() => {
        if (user) {
            dialogRef.current.showModal()
        } else {
            dialogRef.current.close()
        }
    })

    return (
        <dialog
            ref={dialogRef}
            role="alertdialog"
            aria-labelledby="delete-user-title"
            aria-describedby="delete-user-description"
            onCancel={onCancel}>
            <p id="delete-user-title">Delete user?</p>
            <p id="delete-user-description">Delete {user?.id}? This cannot be undone.</p>
            <button type="button" onClick={onCancel} autoFocus>Cancel</button>
            <button type="button" onClick={() => onConfirm(user.id)}>Delete user</button>
        </dialog>
    )
}