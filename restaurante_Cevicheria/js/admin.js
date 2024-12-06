       // Función para cargar contenido dinámico
       function cargarContenido(url) {
        const contenido = document.getElementById('contenido');
        const loader = document.getElementById('loaderPagina');

        // Mostrar loader mientras se carga el contenido
        loader.style.display = 'block';
        contenido.innerHTML = ''; // Limpia el contenido actual

        // Cargar el contenido mediante fetch
        fetch(url)
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Error al cargar el contenido');
                }
                return response.text();
            })
            .then((html) => {
                loader.style.display = 'none'; // Ocultar loader
                contenido.innerHTML = html; // Insertar el contenido
            })
            .catch((error) => {
                loader.style.display = 'none'; // Ocultar loader
                contenido.innerHTML = `<div class="alert alert-danger">No se pudo cargar el contenido: ${error.message}</div>`;
            });
    }