/* script.js atualizado */
window.addEventListener('scroll', function() {
    var navbar = document.getElementById('navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Função para abrir/fechar o menu mobile
function toggleMenu() {
    const nav = document.querySelector('.nav-links');
    nav.classList.toggle('active');
}

document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visivel');
                if (entry.target.classList.contains('anim-trigger')) {
                    entry.target.classList.add('in-view');
                }
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.animar, .anim-trigger').forEach(el => observer.observe(el));
});