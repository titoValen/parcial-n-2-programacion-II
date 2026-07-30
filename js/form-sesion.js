const register_box = document.getElementById('register-box');
const login_box = document.getElementById('login-box');

const registerLink = document.getElementById('register-toggle');
const loginLink = document.getElementById('login-toggle');

register_box.style.display = 'none';
login_box.style.display = 'block';

registerLink.addEventListener('click', () => {
  login_box.style.display = 'none';
  register_box.style.display = 'block';
});

loginLink.addEventListener('click', () => {
  register_box.style.display = 'none';
  login_box.style.display = 'block';
});