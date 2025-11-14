const formLogin = document.getElementById('login-form');

formLogin.addEventListener('submit', async (e) => {
  e.preventDefault();

  const usuario = document.getElementById('usuario-login').value;
  const password = document.getElementById('password-login').value;

  try {
    
    const response = await fetch("http://localhost:8080/singin/login", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ usuario, password })
    });
    
    const data = await response.json();
    

    if (data.success) {
      window.location.href = '/universidades';
    } else {
      alert('Error: ' + data.error);
    }

  } catch (error) {
    console.error('Error en la petición:', error);
  }
});