 // Verificar si el parámetro 'msg' está presente en la URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('msg') && urlParams.get('msg') === 'respuesta_enviada') {
            alert('Respuesta confirmada y enviada a correo.');
        }


        //para que se muestre en el modal
        function showDetails(contactoJson) {
            const contacto = JSON.parse(contactoJson);
            document.getElementById('detail-usuario').textContent = contacto.nombre +' '+ contacto.apellidos || 'N/A';
            document.getElementById('detail-asunto').textContent = contacto.asunto;
            document.getElementById('detail-mensaje').textContent = contacto.mensaje || 'No especificado';
            document.getElementById('detail-fecha').textContent = contacto.fecha_contatanos;
            document.getElementById('detail-respuesta').textContent = contacto.respuesta || 'No respondido';
        }