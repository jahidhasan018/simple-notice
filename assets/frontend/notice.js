;(function ($) {
    "use strict"; // use strict to start

    $(document).ready(function () {
        if (typeof smn_notice === "undefined") {
            return;
        }

        if (parseInt(smn_notice.smn_hide_mobile, 10) === 1 && window.innerWidth < 768) {
            return;
        }

        // Cookie setup
        var visited = $.cookie('visited');
        var noticeShown = false;

        if (visited !== 'yes') {
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
            var smn_hide = parseInt(smn_notice.smn_hide, 10);
            var smn_hide_delay = parseInt(smn_notice.smn_hide_delay, 10);

            if (smn_text) {
                $.notify(smn_text, {
                    position: smn_notice.smn_position || 'bottom center',
                    autoHide: smn_hide === 1,
                    autoHideDelay: smn_hide_delay || 5000,
                    clickToHide: smn_hide === 2,
                    style: smn_notice.smn_style || 'bootstrap',
                    showAnimation: 'slideDown'
                });
                noticeShown = true;
            }
        }

        // Cookie expires date
        if (noticeShown) {
            var smn_cookie_expire = parseInt(smn_notice.smn_cookie_expire, 10);
            if (smn_cookie_expire <= 0) {
                $.removeCookie('visited');
            }
            $.cookie('visited', 'yes', {
                expires: smn_cookie_expire ? smn_cookie_expire : 0 // the number of days cookie will be effective
            });
        }
    });

})(jQuery);
