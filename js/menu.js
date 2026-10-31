// Hamburger (and the mobile logo / header colour swap that goes with it)
document.addEventListener('DOMContentLoaded', function() {
  var menuToggle = document.querySelector('.menu-toggle');
  var mainNavigation = document.querySelector('.main-navigation');
  if (!menuToggle || !mainNavigation) {
    return;
  }

  var logoC4aaMobileRed = document.querySelector('.logo-c4aa-mobile--red');
  var logoC4aaMobileWhite = document.querySelector('.logo-c4aa-mobile--white');
  var siteHeader = document.querySelector('.site-header');
  var widthIsMobile = checkWidth();

  function isOpen() {
    return menuToggle.getAttribute('aria-expanded') === 'true';
  }

  function setMenu(open) {
    menuToggle.classList.toggle('active', open);
    menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    mainNavigation.style.display = (open || !widthIsMobile) ? 'block' : 'none';
    if (logoC4aaMobileRed) logoC4aaMobileRed.classList.toggle('active', !open);
    if (logoC4aaMobileWhite) logoC4aaMobileWhite.classList.toggle('active', open);
    if (siteHeader) siteHeader.classList.toggle('active', open);
  }

  menuToggle.addEventListener('click', function() {
    setMenu(!isOpen());
  });

  // Escape closes the menu and puts focus back on the toggle
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && isOpen()) {
      setMenu(false);
      menuToggle.focus();
    }
  });

  // Only react when the viewport crosses the mobile breakpoint. Mobile
  // browsers fire resize when the URL bar collapses or the keyboard opens,
  // and that shouldn't snap an open menu shut.
  window.addEventListener('resize', function() {
    var nowMobile = checkWidth();
    if (nowMobile === widthIsMobile) {
      return;
    }
    widthIsMobile = nowMobile;
    setMenu(false);
  });
});

// Check if the screen is mobile

function checkWidth() {
  return window.innerWidth < 769;
}


// Replace plain link SVG with Search Icon SVG

document.addEventListener("DOMContentLoaded", function() {
  // Select all span elements with the class screen-reader-text
  var spanElements = document.querySelectorAll('span.screen-reader-text');
  
  spanElements.forEach(function(spanElement) {
    // Check if the span element contains the text "Search"
    if (spanElement.textContent.trim() === "Search") {
      // Get the parent li element of the selected span
      var menuItem = spanElement.closest('li');
      
      if (menuItem) {
        // Path to the new SVG file
        var searchSVG = `
        <svg class="svg-icon" width="24" height="24" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
        <path d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z"/>
        </svg>
        `;
        
        // Find the existing SVG within the menu item
        var existingSVG = menuItem.querySelector("svg");
        
        // Replace the existing SVG with the new SVG
        if (existingSVG) {
          existingSVG.outerHTML = searchSVG;
          // Show the menu item now that the new SVG is loaded
          menuItem.classList.add('svg-loaded');
        }
      }
    }
  });
});