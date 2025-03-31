// Smooth scrolling to anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
  
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
  });  
  
  // watches for clicks on either `.site-featured-image` and `.entry-content > :first-child.wp-block-pullquote` elements, and includes an exception for clicks on an anchor tag link within those elements. Once a click is detected, the function will scroll to the title of the page.
  // written by github copilot and modified by me.
    document.addEventListener('click', function (event) {
        if (event.target.closest('.site-featured-image, .entry-content > :first-child.wp-block-pullquote') && !event.target.closest('a')) {
        document.querySelector('.entry-header h1.entry-title').scrollIntoView({
            behavior: 'smooth'
        });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
      const form = document.querySelector('form'); // Adjust this selector if needed
      const submitBtn = form.querySelector('.frm_button_submit');
      const spinner = form.querySelector('.spinner');
    
      form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
        spinner.style.display = 'inline-block';
      });
    });



