Array.from(document.getElementsByClassName("view-product")).forEach((btn) => {
  btn.addEventListener("click", () => {
    window.location.assign(`viewProduct.php?id=${btn.id}`);
  });
});
document.addEventListener("DOMContentLoaded", function () {
  const slider = tns({
    container: ".product-slider",
    items: 1,
    slideBy: 1,
    autoplay: false,
    controls: true,
    nav: false,
    edgePadding: 60,
    mouseDrag: true,
    gutter: 40,
    loop: true,
    controlsContainer: "#controls",
    responsive: {
      640: {
        items: 2,
      },
      768: {
        items: 3,
      },
      1024: {
        items: 4,
      },
    },
  });
});
function openModal(modalId) {
 modalId.style.display = "flex";
}
function closeModal(modalId) {
  modalId.style.display = "none";
}
document.addEventListener('DOMContentLoaded', function() {
  const wrapper = document.querySelector('.authors-wrapper');
  const scrollers = document.querySelectorAll('.authors-scroll');
  
  // Check if elements exist
  if (!wrapper || !scrollers.length) return;

  // Adjust animation speed based on content width
  function adjustSpeed() {
      const contentWidth = scrollers[0].offsetWidth;
      const duration = Math.max(20, contentWidth / 50); // Adjust base speed here
      
      scrollers.forEach(scroller => {
          scroller.style.animationDuration = `${duration}s`;
      });
  }

  // Initial speed adjustment
  adjustSpeed();

  // Adjust speed on window resize
  window.addEventListener('resize', adjustSpeed);

  // Check if the user's device/browser prefers reduced motion
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  
  if (prefersReducedMotion.matches) {
      scrollers.forEach(scroller => {
          scroller.style.animation = 'none';
      });
  }
});