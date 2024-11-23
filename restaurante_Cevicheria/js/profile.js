document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const tabContents = document.querySelectorAll('.tab-content');

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Remove active class from all links and tabs
            navLinks.forEach(l => l.classList.remove('active'));
            tabContents.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked link
            link.classList.add('active');
            
            // Show corresponding tab content
            const targetId = link.getAttribute('data-target');
            document.getElementById(targetId).classList.add('active');
        });
    });
});


