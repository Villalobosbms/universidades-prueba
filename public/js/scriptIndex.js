const loginButton = document.getElementById('login');
const registerButton = document.getElementById('register');

loginButton.addEventListener('click', () => {
  window.location.href = '/login';
});

registerButton.addEventListener('click', () => {
  window.location.href = '/register';
});



