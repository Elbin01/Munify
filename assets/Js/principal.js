document.addEventListener('DOMContentLoaded', () => {
    const navMenu = document.getElementById('nav-menu');
    const hamIcon = document.getElementById('ham-icon');
    const hamburgerBtn = document.getElementById('hamburger-btn');

    // Menu Toggle Logic
    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', () => {
            navMenu.classList.toggle('open');
            hamIcon.className = navMenu.classList.contains('open') ? 'fas fa-xmark' : 'fas fa-bars';
        });
    }

    // Close menu when clicking links
    document.querySelectorAll('#nav-menu a').forEach(a => {
        a.addEventListener('click', () => {
            if (navMenu.classList.contains('open')) {
                navMenu.classList.remove('open');
                if (hamIcon) hamIcon.className = 'fas fa-bars';
            }
        });
    });

    // Handle smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});
