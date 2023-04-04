;(function ($) {
    "use strict"; // use strict to start
    
    $(document).ready(function () {
        
        // Cookie setup
        var visited = $.cookie('visited');
        if(visited == 'yes') {
             // second page load, cookie active
        }else {
            
            // Custom style happyblue
            $.notify.addStyle('happyblue', {
              html: "<div>☺<span data-notify-text/>☺ &times;</div>",
              classes: {
                base: {
                  "white-space": "nowrap",
                  "background-color": "lightblue",
                  "padding": "5px"
                },
                superblue: {
                  "color": "white",
                  "background-color": "blue"
                }
              }
            });
            
            // Custom style blackBg
            $.notify.addStyle('blackBg', {
              html: "<div><span data-notify-text/> &times;</div>",
              classes: {
                base: {
                  "white-space": "nowrap",
                  "background-color": "#000",
                  "padding": "5px 20px",
                  "color": "white"
                },
                superblue: {
                  "color": "white",
                  "background-color": "#000"
                }
              }
            });
            
            // Notice Settings
            var smn_text = smn_notice.smn_text;
            var smn_hide = smn_notice.smn_hide;
            var smn_hide_delay = smn_notice.smn_hide_delay;
            
            if(smn_text){
               $.notify(smn_text, {
                   position: smn_notice.smn_position == smn_notice.smn_position ? smn_notice.smn_position : 'bottom center',
                   autoHide: smn_hide == 1 ? true : false,
                   autoHideDelay: smn_hide_delay,
                   clickToHide: smn_hide == 2 ? true : false,
                   style: smn_notice.smn_style == smn_notice.smn_style ? smn_notice.smn_style : 'bootstrap',
                   showAnimation: 'slideDown'
               });
            }
            
        }
        
        // Cookie expires date
        var smn_cookie_expire = smn_notice.smn_cookie_expire;
        if(smn_cookie_expire <= 0){
            $.removeCookie('visited');
        }
        $.cookie('visited', 'yes', {
            expires: smn_cookie_expire?parseInt(smn_cookie_expire):0 // the number of days cookie  will be effective
        });
        
        
    });
    
})(jQuery);