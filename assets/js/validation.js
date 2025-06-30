const form = document.getElementById('form')
const fname_input = document.getElementById('fname-input')
const email_input = document.getElementById('email-input')
const password_input = document.getElementById('password-input')
const repeat_password_input = document.getElementById('repeat-password-input')
const error_message = document.getElementById('error-message')

form.addEventListener('submit', (e) => {
    // Limpar qualquer erro anterior
    clearPreviousErrors()

    let errors = []
    if(fname_input){
        errors = getSignupFormErrors(fname_input.value, email_input.value, password_input.value, repeat_password_input.value)
    }
    else{
        errors = getLoginFormErrors(email_input.value, password_input.value)
    }

    if(errors.length > 0){
        e.preventDefault()
        error_message.innerText = errors.join(". ")
    }
})

function getSignupFormErrors(fname, email, password, repeatPassword){
    let errors = []

    if (!fname) {
        errors.push('Nome Completo é necessário!')
        fname_input.parentElement.classList.add('incorrect')
    }
    if (!email) {
        errors.push('E-mail é necessário!')
        email_input.parentElement.classList.add('incorrect')
    }
    if (!password) {
        errors.push('Senha é necessária!')
        password_input.parentElement.classList.add('incorrect')
    }
    if (password !== repeatPassword) {
        errors.push('As senhas não coincidem!')
        repeat_password_input.parentElement.classList.add('incorrect')
    }

    return errors
}

function clearPreviousErrors() {
    // Limpa os estilos de erro e as mensagens anteriores
    const inputs = [fname_input, email_input, password_input, repeat_password_input]
    inputs.forEach(input => {
        input.parentElement.classList.remove('incorrect')
    })
    error_message.innerText = ''
}
