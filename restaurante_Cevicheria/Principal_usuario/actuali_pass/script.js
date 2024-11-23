// Contador regresivo
let timeLeft = 5;
const countdownElement = document.getElementById('countdown');

const countdown = setInterval(() => {
    timeLeft--;
    countdownElement.textContent = timeLeft;
    
    if (timeLeft <= 0) {
        clearInterval(countdown);
        window.location.href = '/restaurante_Cevicheria/Principal_usuario/Login/index.php';
    }
}, 1000);