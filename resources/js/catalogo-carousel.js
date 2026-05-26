/* Catálogo - Carrossel leve (passo (3)) */

function initCatalogoCarousels() {
  const carousels = document.querySelectorAll('.package-image-carousel');
  if (!carousels.length) return;

  carousels.forEach((carousel) => {
    const track = carousel.querySelector('.image-carousel-track');
    if (!track) return;

    const images = Array.from(track.querySelectorAll('img'));
    if (images.length <= 1) return;

    let index = 0;
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const intervalMs = prefersReducedMotion ? 999999 : 3500; // lento/polido

    // Pré-define posição
    const setPosition = () => {
      const x = -index * 100;
      track.style.transform = `translateX(${x}%)`;
    };

    // Evita múltiplos timers
    let timer = null;

    const start = () => {
      if (timer) return;
      timer = window.setInterval(() => {
        index = (index + 1) % images.length;
        setPosition();
      }, intervalMs);
    };

    // Pausa ao hover
    carousel.addEventListener('mouseenter', () => {
      if (timer) {
        window.clearInterval(timer);
        timer = null;
      }
    });

    carousel.addEventListener('mouseleave', () => {
      start();
    });

    // Inicia
    setPosition();
    start();
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initCatalogoCarousels);
} else {
  initCatalogoCarousels();
}

