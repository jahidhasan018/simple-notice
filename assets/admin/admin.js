;(function ($) {
    "use strict"; // use strict to start
    
    $(document).ready(function () {
        
        // Conditional display for Auto Hide Delay field
        var $hideBehaviorSelect = $('#smn_hide');
        var $delayFieldWrapper = $('#smn_delay_field'); 

        function toggleDelayField() {
            if ($hideBehaviorSelect.val() === '1') { // '1' for Auto Hide
                $delayFieldWrapper.slideDown(); // Use slideDown for a nicer effect
            } else {
                $delayFieldWrapper.slideUp();   // Use slideUp for a nicer effect
            }
        }

        // Initial check on page load
        toggleDelayField();

        // Bind change event
        $hideBehaviorSelect.on('change', toggleDelayField);

        // Initialize WordPress color picker
        if (typeof $.fn.wpColorPicker === 'function') {
            $('.smn-color-picker').wpColorPicker();
        }
        
    });
    
})(jQuery);