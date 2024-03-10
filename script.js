
    const formBoxLogin = document.querySelector('.form-box.login');
    const formBoxRegister = document.querySelector('.form-box.register');
    const btnPopup = document.querySelector('.btnLogin-popup');
    const loginLink = document.querySelector('.login-link');
    const registerLink = document.querySelector('.register-link');
    const iconCloseLogin = document.getElementById('iconCloseLogin');
    const iconCloseRegister = document.getElementById('iconCloseRegister');

    // Initially hide all form boxes 
    formBoxLogin.classList.display = 'none';
    formBoxRegister.classList.display = 'none';

    registerLink.addEventListener('click', () => {
        formBoxRegister.classList.add('active');
    });
    
    loginLink.addEventListener('click', () => {
        formBoxRegister.classList.remove('active');
    });
    
    // Show form box on login button click
    btnPopup.addEventListener('click', () => {
        formBoxLogin.classList.add('active-popup');
    });
    // Close form box on icon close click
    iconCloseLogin.addEventListener('click', () => {
        formBoxLogin.classList.remove('active-popup');
    });
    iconCloseRegister.addEventListener('click', () => {
        formBoxRegister.classList.remove('active-popup');
    });
    
    