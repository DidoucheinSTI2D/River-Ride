function togglePassword(button) {
    var passwordElement = button.parentNode.previousElementSibling.querySelector('.password');
    if (passwordElement.dataset.password) {
        passwordElement.textContent = passwordElement.dataset.password;
        passwordElement.removeAttribute('data-password');
        button.textContent = 'Cacher';
    } else {
        passwordElement.dataset.password = passwordElement.textContent;
        passwordElement.textContent = '********';
        button.textContent = 'Voir';
    }
}