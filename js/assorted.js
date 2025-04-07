// Assorted JavaScript functions 

// Donate-a-tron 3001 form: One-time ==> Monthly donation calculator
jQuery(document).ready(function($) {
    // Listen for clicks on the "switch-to-monthly" link
    $(document).on('click', '.switch-to-monthly', function(e) {
        e.preventDefault();
        
        // Get the current suggested amount from the inline total
        const suggestedAmount = $('.frm_inline_total').text().replace('$', '').trim();
        
        // Select the "Monthly" radio button
        $('#field_monthly3-1').prop('checked', true).trigger('change');
        
        // Select the "Other" amount option
        $('#field_donation-amount3-other_6').prop('checked', true).trigger('change');
        
        // Wait a moment for the "Other" input field to become visible
        setTimeout(function() {
            // Set the value in the "Other" amount field
            $('#field_donation-amount3-other_6-otext').val(suggestedAmount).trigger('change');
        }, 100);
        
        // Hide the conversion prompt since the user has converted
        $('#frm_field_2893_container').hide(); 
    });
});