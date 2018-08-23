function theChampHorizontalCounterOptionsToggle(t) {
    jQuery(t).is(":checked") ? jQuery("#the_champ_horizontal_counter_options").css("display", "table-row-group") : jQuery("#the_champ_horizontal_counter_options").css("display", "none")
}

function theChampVerticalCounterOptionsToggle(t) {
    jQuery(t).is(":checked") ? jQuery("#the_champ_vertical_counter_options").css("display", "table-row-group") : jQuery("#the_champ_vertical_counter_options").css("display", "none")
}

function theChampToggleOffset(t) {
    var e = "left" == t ? "right" : "left";
    jQuery("#the_champ_sc_" + t + "_offset_rows").css("display", "table-row-group"), jQuery("#the_champ_sc_" + e + "_offset_rows").css("display", "none")
}

function theChampClearShorturlCache(){
    jQuery('#shorturl_cache_loading').css('display', 'block');
    jQuery.ajax({
        type: 'GET',
        dataType: 'json',
        url: theChampSharingAjaxUrl,
        data: {
            action: 'the_champ_clear_shorturl_cache'
        },
        success: function(data, textStatus, XMLHttpRequest){
            jQuery('#shorturl_cache_loading').css('display', 'none');
            jQuery('#the_champ_cache_clear_message').css('display', 'block');
        }
    });
}

"function" != typeof String.prototype.trim && (String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, "")
}), jQuery(document).ready(function() {
    jQuery("#the_champ_sc_rearrange, #the_champ_sc_vertical_rearrange").sortable(), jQuery("#the_champ_target_url_column").find("input[type=radio]").click(function() {
        jQuery(this).attr("id") && "the_champ_target_url_custom" == jQuery(this).attr("id") ? jQuery("#the_champ_target_url_custom_url").css("display", "block") : jQuery("#the_champ_target_url_custom_url").css("display", "none")
    }), jQuery("#the_champ_vertical_target_url_column").find("input[type=radio]").click(function() {
        jQuery(this).attr("id") && "the_champ_vertical_target_url_custom" == jQuery(this).attr("id") ? jQuery("#the_champ_vertical_target_url_custom_url").css("display", "block") : jQuery("#the_champ_vertical_target_url_custom_url").css("display", "none")
    }), jQuery("#the_champ_target_url_custom").is(":checked") ? jQuery("#the_champ_target_url_custom_url").css("display", "block") : jQuery("#the_champ_target_url_custom_url").css("display", "none"), jQuery("#the_champ_vertical_target_url_custom").is(":checked") ? jQuery("#the_champ_vertical_target_url_custom_url").css("display", "block") : jQuery("#the_champ_vertical_target_url_custom_url").css("display", "none")
});