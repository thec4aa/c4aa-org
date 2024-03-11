// Hamburger
document.addEventListener('DOMContentLoaded', function() {
  var menuToggle = document.querySelector('.menu-toggle');
  var mainNavigation = document.querySelector('.main-navigation');
  var menuIsActive = false;
  var widthIsMobile = checkWidth();

  window.addEventListener('resize', function(){
    widthIsMobile = checkWidth();
    menuIsActive = false;
    menuToggle.classList.remove('active');
    mainNavigation.style.display = (widthIsMobile) ? 'none' : 'block';
  });

  if (menuToggle) {
      menuToggle.addEventListener('click', function() {
        menuIsActive = !menuIsActive;
          menuToggle.classList.toggle('active');
          mainNavigation.style.display = (menuIsActive) ? 'block' : 'none';
      });
  }
});
// Toggle red and white logos
document.addEventListener('DOMContentLoaded', function() {
  var menuToggle = document.querySelector('.menu-toggle');
  var logoC4aaMobileRed = document.querySelector('.logo-c4aa-mobile--red');
  var logoC4aaMobileWhite = document.querySelector('.logo-c4aa-mobile--white');
  var siteHeader = document.querySelector('.site-header');
  var menuIsActive = false;
  var widthIsMobile = checkWidth();

  window.addEventListener('resize', function(){
    widthIsMobile = checkWidth();
    if(widthIsMobile) {
      logoC4aaMobileRed.classList.add('active');
      logoC4aaMobileWhite.classList.remove('active');
      siteHeader.classList.remove('active');
    }
  });

  if (menuToggle) {
      menuToggle.addEventListener('click', function() {
          logoC4aaMobileRed.classList.toggle('active');
          logoC4aaMobileWhite.classList.toggle('active');
          siteHeader.classList.toggle('active');
    });
  }
});

function checkWidth() {
  return window.innerWidth < 769;
}