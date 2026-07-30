const register_box = document.getElementById('register-box');
const login_box = document.getElementById('login-box');

const registerLink = document.getElementById('register-toggle');
const loginLink = document.getElementById('login-toggle');

function setSessionUrl() {
  const url = new URL(window.location.href);

  url.searchParams.set('vista', 'sesion');
  url.searchParams.delete('error');

  history.replaceState({}, '', url.pathname + '?' + url.searchParams.toString() + url.hash);
}

function clearAuthError() {
  const authError = document.getElementById('auth-error-message');

  if (authError) {
    authError.remove();
  }
}

register_box.style.display = 'none';
login_box.style.display = 'block';

registerLink.addEventListener('click', () => {
  setSessionUrl();
  clearAuthError();
  login_box.style.display = 'none';
  register_box.style.display = 'block';
});

loginLink.addEventListener('click', () => {
  setSessionUrl();
  clearAuthError();
  register_box.style.display = 'none';
  login_box.style.display = 'block';
});