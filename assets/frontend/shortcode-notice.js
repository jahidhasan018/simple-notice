jQuery(document).ready(function($) {
    $('.smn-notice-btn-shortcode').each(function() {
        var $button = $(this);
        var noticeText = $button.data('notice-text');
        var noticePosition = $button.data('position') || 'top center'; // Default
        var noticeClickToHide = $button.data('click-to-hide'); // Will be true/false from data attribute
        var noticeAutoHide = $button.data('auto-hide');       // Will be true/false from data attribute
        var noticeAutoHideDelay = parseInt($button.data('auto-hide-delay')) || 3000; // Default
        var noticeStyle = $button.data('style') || 'bootstrap'; // Default
        var noticeUrl = $button.attr('href'); // Get URL from href
        // var noticeType = $button.data('type') || 'info'; // Example for future enhancement

        if (noticeText) {
            $button.on('click', function(e) {
                if (noticeUrl === '#') {
                    e.preventDefault();
                }
                
                // Ensure notify.js is available (it should be due to dependencies)
                if (typeof $.notify === 'function') {
                    $('body').notify(
                        noticeText,
                        {
                            position: noticePosition,
                            clickToHide: noticeClickToHide, 
                            autoHide: noticeAutoHide,    
                            autoHideDelay: noticeAutoHideDelay,
                            style: noticeStyle,
                            className: 'info' // Default class for shortcode notices. 
                                              // Can be made dynamic via another data-attribute e.g. data-type if needed.
                        }
                    );
                } else {
                    console.error('Notify.js not loaded for smn-shortcode-js. Ensure smn-notify-js is registered and enqueued correctly with its dependencies.');
                }
            });
        }
    });
});
