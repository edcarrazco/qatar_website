jQuery(document).ready(function ($) {

    jQuery('.brands-field-upload-btn').on('click', function() {
        var parent=jQuery(this).parents('.brands-field');
        var inputField = jQuery(parent).find(".brands-upload-img");
        var fileFrame = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
        fileFrame.on('select', function() {
            var url = fileFrame.state().get('selection').first().toJSON();
            inputField.val(url.url);
            jQuery(parent)
                .find(".brands-field-img")
                .html('<img src="'+url.url+'" width="48" alt="">');
        });
        fileFrame.open();
        jQuery(parent).find(".brands-field-remove-btn").show();
    });
     
    jQuery('.brands-field-remove-btn').on('click', function() {
        var parent=jQuery(this).parents('.brands-field');
        jQuery(parent).find(".brands-upload-img").val('');
        jQuery(parent).find(".brands-field-img").html('');
        jQuery(parent).find(".brands-field-remove-btn").hide();
        return false;
    });
 
});

