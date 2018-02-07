/**
 * Script used for window previewed in Translation Editor.
 */
function TRP_Iframe_Preview(){

    var _this = this;

    /**
     * Add GET preview parameter for links and forms.
     */
    this.initialize = function() {
        jQuery('a').each(function () {
            // target parent brakes from the iframe so we're removing it entirely
            jQuery(this).removeAttr('target');

            if( typeof this.href != "undefined" && this.href != '' ) {
                if (this.action != '' && this.href.indexOf('void(0)') === -1) {
                    if (is_link_previewable(this) && !this.getAttribute('href').startsWith('#')) {
                        this.href = update_query_string('trp-edit-translation', 'preview', this.getAttribute('href'));
                        /* pass on trp-view-as parameters to all links that also have preview parameter */
                        if( typeof URL == 'function' && window.location.href.search("trp-view-as=") >= 0 && window.location.href.search("trp-view-as-nonce=") >= 0 ){
                            var currentUrl = new URL(window.location.href);
                            this.href = update_query_string('trp-view-as', currentUrl.searchParams.get("trp-view-as"), this.href);
                            this.href = update_query_string('trp-view-as-nonce', currentUrl.searchParams.get("trp-view-as-nonce"), this.href);
                        }

                    } else {
                        jQuery(this).on('click',
                            function (event) {
                                event.preventDefault();
                            }
                        );
                    }
                }
            }
        });

        jQuery('form').each(function () {
            jQuery( this ).append( jQuery('<input></input>').attr({ type: 'hidden', value: 'preview', name: 'trp-edit-translation' }) );
        });

    };

    /**
     * Update url with query string.
     *
     */
    function update_query_string(key, value, url) {
        if (!url) url = window.location.href;
        var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
            hash;

        if (re.test(url)) {
            if (typeof value !== 'undefined' && value !== null)
                return url.replace(re, '$1' + key + "=" + value + '$2$3');
            else {
                hash = url.split('#');
                url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
                if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                    url += '#' + hash[1];
                return url;
            }
        }
        else {
            if (typeof value !== 'undefined' && value !== null ) {
                var separator = url.indexOf('?') !== -1 ? '&' : '?';
                hash = url.split('#');
                url = hash[0] + separator + key + '=' + value;
                if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                    url += '#' + hash[1];
                return url;
            }
            else
                return url;
        }
    }

    /**
     * Return boolean whether element has unpreviewable attribute.
     */
    function is_link_previewable( element ) {
        if ( jQuery( element ).attr( 'data-trp-unpreviewable' ) == 'trp-unpreviewable' ){
            return false;
        }
        return true;
    }

    _this.initialize();
}

var trp_preview_iframe;

jQuery( function(){
    trp_preview_iframe = new TRP_Iframe_Preview();
});

/**
 *   the startsWith method is not supported in IE so in that case we need to implement it
 */
if (!String.prototype.startsWith) {
    String.prototype.startsWith = function(searchString, position) {
        position = position || 0;
        return this.indexOf(searchString, position) === position;
    };
}