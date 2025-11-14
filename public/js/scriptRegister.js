const formCrearUsuario = document.getElementById('regiter-form');

formCrearUsuario.addEventListener('submit', async (e) => {
  e.preventDefault();

  
  const usuario = document.getElementById('usuario-register').value;
  const password = document.getElementById('password-register').value;

  try {
    
    const response = await fetch("http://localhost:8080/crearUsuario/register", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ usuario, password })
    });

    const data = await response.json();

    console.log('Respuesta del servidor:', data);
    console.log(data)
    if (data.success) {
      window.location.href = '/login';
      alert('Usuario: ' + data.success)
    } else {
      alert('Error: ' + data.error);
    }

  } catch (error) {
    console.error('Error en la petición:');
  }
});