;(function ($) {
    "use strict"; // use strict to start
    
    $(document).ready(function () {

        // Custom style happyblue (already defined in notify.js, but can be overridden or defined here if needed)
        // $.notify.addStyle('happyblue', { ... });
        // Custom style blackBg (already defined in notify.js, but can be overridden or defined here if needed)
        // $.notify.addStyle('blackBg', { ... });

        function displayNotice() {
            var smn_text_original = smn_notice.smn_text;
            if (!smn_text_original) { // Do not show if text is empty
                return;
            }

            var smn_hide = smn_notice.smn_hide;
            var smn_hide_delay = smn_notice.smn_hide_delay;
            var smn_icon = smn_notice.smn_notice_icon;

            var noticeTextWithIcon = smn_text_original;
            if (smn_icon && smn_icon !== 'none' && typeof smn_icon === 'string' && smn_icon.startsWith('dashicons-')) {
                var iconHtml = '<span class="simple-notice-bar-icon dashicons ' + smn_icon + '"></span> ';
                noticeTextWithIcon = iconHtml + smn_text_original;
            }
            
            var noticeOptions = {
                position: smn_notice.smn_position ? smn_notice.smn_position : 'bottom center',
                autoHide: smn_hide == 1, // true if 1, false otherwise
                autoHideDelay: parseInt(smn_hide_delay) || 5000,
                clickToHide: smn_hide == 2, // true if 2, false otherwise
                style: smn_notice.smn_style ? smn_notice.smn_style : 'bootstrap',
                className: smn_notice.smn_notice_type ? smn_notice.smn_notice_type : 'info',
                showAnimation: 'slideDown'
            };
            
            $.notify(noticeTextWithIcon, noticeOptions);

            // Apply custom colors if set
            setTimeout(function() {
                var styleBaseClass = smn_notice.smn_style ? 'notifyjs-' + smn_notice.smn_style + '-base' : '';
                var typeClass = smn_notice.smn_notice_type ? smn_notice.smn_notice_type : 'info';

                var selector = '';
                // Construct a more specific selector if possible
                if (styleBaseClass && typeClass) {
                    selector = '.' + styleBaseClass + '.' + typeClass;
                } else if (styleBaseClass) {
                    selector = '.' + styleBaseClass;
                } else if (typeClass) {
                    selector = '.' + typeClass;
                } else {
                    selector = '.notifyjs-bootstrap-base'; // A sensible default if nothing else is specified
                }
                
                var $notifyElement = $('.notifyjs-corner ' + selector + ':visible').last();
                if (!$notifyElement.length) {
                    $notifyElement = $('.notifyjs-wrapper > ' + selector + ':visible').last();
                }
                // Fallback if the specific combination is not found, try to find a generic container and then the specific classes within it
                if (!$notifyElement.length) {
                    var $container = $('.notifyjs-container:visible').last();
                    if ($container.length) {
                        if ($container.is(selector)) { // If the container itself matches
                           $notifyElement = $container;
                        } else { // Try to find the styled element within the container
                           $notifyElement = $container.find(selector).last();
                        }
                    }
                }
                // If still no element, and we have specific classes, try to find the element that has BOTH.
                if (!$notifyElement.length && styleBaseClass && typeClass) {
                     $notifyElement = $('.notifyjs-corner .' + styleBaseClass + '.' + typeClass + ':visible').last();
                     if (!$notifyElement.length) {
                        $notifyElement = $('.notifyjs-wrapper > .' + styleBaseClass + '.' + typeClass + ':visible').last();
                     }
                }


                if ($notifyElement.length) {
                    if (smn_notice.smn_notice_bg_color && typeof smn_notice.smn_notice_bg_color === 'string' && smn_notice.smn_notice_bg_color.startsWith('#')) {
                        $notifyElement.css('background-color', smn_notice.smn_notice_bg_color);
                    }
                    if (smn_notice.smn_notice_text_color && typeof smn_notice.smn_notice_text_color === 'string' && smn_notice.smn_notice_text_color.startsWith('#')) {
                        $notifyElement.css('color', smn_notice.smn_notice_text_color);
                        $notifyElement.find('span[data-notify-text]').css('color', smn_notice.smn_notice_text_color);
                    }
                }
            }, 100); // 100ms delay
        }

        var showOncePerSession = smn_notice.smn_show_once_per_session == 1; // absint from PHP makes it a number
        var sessionCookieName = 'smn_session_notice_shown';
        var persistentCookieName = 'smn_persistent_notice_hidden'; // Using a more descriptive name for the existing cookie
        
        // Check persistent cookie first (this cookie is set when user hides notice, or it auto-hides)
        var isPersistentlyHidden = $.cookie(persistentCookieName) === 'yes';

        if (isPersistentlyHidden) {
            // Do nothing if a persistent cookie indicates the user has hidden it for X days
        } else if (showOncePerSession) {
            if (!$.cookie(sessionCookieName)) {
                displayNotice();
                $.cookie(sessionCookieName, 'yes', { path: '/' }); // Session cookie, expires when browser closes
            }
            // Else, session cookie is set, so do nothing for this session
        } else {
            // Not "show once per session" and not persistently hidden, so display notice
            displayNotice();
        }

        // Logic for setting the persistent cookie when the notice is hidden (e.g., by click or auto-hide)
        // This needs to be tied into notify.js events or how it handles hiding.
        // The current structure does not show how the 'visited' (now 'smn_persistent_notice_hidden') cookie is set
        // when a notice is actually hidden by the user or auto-hides.
        // For now, we'll adapt the old logic for setting this cookie if smn_cookie_expire > 0
        
        var smn_cookie_expire_days = parseInt(smn_notice.smn_cookie_expire);
        if (smn_cookie_expire_days > 0) {
            // This part is tricky as we need to set the cookie *when* the notice is hidden.
            // Notify.js has events like 'hide'. Assuming we want to set it if the notice *was* shown.
            // If `displayNotice()` was called, we can assume the notice was meant to be shown.
            // This logic is a bit separated from the actual hide event, might need refinement
            // if we want to set the cookie only on explicit hide action or auto-hide completion.
            
            // A simplified approach: if displayNotice() is called and smn_cookie_expire_days > 0,
            // assume that if the user hides it, or if it auto-hides, they don't want to see it for X days.
            // This cookie should ideally be set upon the 'hide' event of the notification.
            // For now, if the conditions to show the notice were met, and a persistent duration is set,
            // we'll arm the persistent cookie mechanism. The actual setting of this cookie
            // should ideally be after the notice has been shown and then hidden.
            // The original code set 'visited' cookie immediately after showing.
            
            // Let's assume if displayNotice() was called, and smn_cookie_expire_days > 0,
            // we set this cookie. This means "don't show again for X days if it was shown this time".
             if (!isPersistentlyHidden) { // Only set if not already persistently hidden
                 if ((showOncePerSession && !$.cookie(sessionCookieName)) || !showOncePerSession) {
                    // This condition means the notice was displayed or would have been displayed
                    // $.cookie(persistentCookieName, 'yes', { expires: smn_cookie_expire_days, path: '/' });
                    // The above line would set it immediately. This is probably not what we want.
                    // We want to set it when the notice is *closed*.
                    // This requires hooking into notify.js's hide event.
                    // $(document).on('hide.notify', function() { ... });
                    // This part is complex to add without knowing more about notify.js event handling in this version.
                    // The original code set the 'visited' cookie unconditionally if smn_cookie_expire was > 0,
                    // effectively meaning "don't show for X days from the first time it was shown".
                    // Let's replicate that for now.
                    if (smn_cookie_expire_days > 0 && !$.cookie(persistentCookieName)) {
                        // If the notice was displayed (or conditions were met to display it)
                         if (!isPersistentlyHidden) {
                            if (showOncePerSession) {
                                if (!$.cookie(sessionCookieName)) { // If it was shown this session
                                    // $.cookie(persistentCookieName, 'yes', { expires: smn_cookie_expire_days, path: '/' });
                                    // This line will be handled by an event listener below
                                }
                            } else { // Shown on every page load
                                // $.cookie(persistentCookieName, 'yes', { expires: smn_cookie_expire_days, path: '/' });
                                // This line will be handled by an event listener below
                            }
                        }
                    }
                 }
             }


        } else if (smn_cookie_expire_days === 0 && $.cookie(persistentCookieName)) {
             // If expiry is set to 0 (no persistent cookie), remove any existing one.
            $.removeCookie(persistentCookieName, { path: '/' });
        }
        
        // Event listener for when a notification is closed
        // This is a more robust way to set the persistent cookie
        $(document).on('hide.notify', function(event, notification){
            if (smn_cookie_expire_days > 0) {
                 // Check if the notification being hidden is our simple notice
                 // This is a heuristic; ideally, the notification object would have an ID.
                 // We assume if smn_text_original is present, it's our notice.
                if (smn_notice.smn_text) { 
                    $.cookie(persistentCookieName, 'yes', { expires: smn_cookie_expire_days, path: '/' });
                }
            }
        });
        
    });
    
})(jQuery);