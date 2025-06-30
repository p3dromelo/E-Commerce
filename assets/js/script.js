// Função para alternar entre formulários de login e registro
function showForm(formId) {
    const targetForm = document.getElementById(formId);

    if (targetForm) {
        document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
        targetForm.classList.add("active");
    } else {
        console.error(`❌ Formulário com o ID '${formId}' não encontrado!`);
    }
}

// Alternar automaticamente para o formulário correto
window.addEventListener('DOMContentLoaded', () => {
    const activeForm = document.querySelector(".form-box.active");
    if (!activeForm) {
        const loginForm = document.getElementById('login-form');
        if (loginForm) loginForm.classList.add('active');
    }

    // === Visibilidade da Senha ===
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', () => {
            const inputId = icon.getAttribute('data-target');
            const input = document.getElementById(inputId);

            if (input) {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';

                // Alterna os ícones (olho aberto/fechado)
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            } else {
                console.warn(`⚠️ Campo de senha com id '${inputId}' não encontrado.`);
            }
        });
    });
});
