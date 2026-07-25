export function formatDateInputValue(value) {
    if (typeof value !== 'string') {
        return undefined
    }

    const date = value.trim().slice(0, 10)

    return /^\d{4}-\d{2}-\d{2}$/.test(date) ? date : undefined
}
