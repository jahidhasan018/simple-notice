;(function ($) {
    "use strict"; // use strict to start
    
    $(document).ready(function () {
        
        // Show autoHide delay input
        var default_hide =  $('#smn_hide').val();
        if( default_hide == 2 ){
            $('#smn_delay_field').hide();
        }
        $('#smn_hide').on('change', function() {
            var value = this.value;
            if( value == 1 ){
                $('#smn_delay_field').show();
            }else{
                $('#smn_delay_field').hide();
            }
        });
        
    });
    
})(jQuery);