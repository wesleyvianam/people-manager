
export function phoneMask(value) {
    return value
        .replace(/\D/g, '') // Remove caracteres não numéricos
        .replace(/^(\d{2})(\d)/g, '($1) $2') // Adiciona o código de área
        .replace(/(\d{4,5})(\d{4})$/, '$1-$2'); // Adiciona o hífen entre os números
}
