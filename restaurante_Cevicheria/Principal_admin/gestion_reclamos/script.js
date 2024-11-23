 // Verificar si el parámetro 'msg' está presente en la URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('msg') && urlParams.get('msg') === 'respuesta_enviada') {
            alert('Respuesta confirmada y enviada a correo.');
        }