export async function graphqlRequest(query, variables = {}) {
    const response = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query, variables }),
    })
    
    const result = await response.json();
    
    return result.data;
}
