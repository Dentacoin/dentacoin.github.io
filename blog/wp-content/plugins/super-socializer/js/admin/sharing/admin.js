function theChampCapitaliseFirstLetter(e) {
    return e.charAt(0).toUpperCase() + e.slice(1)
}

function theChampHorizontalSharingOptionsToggle(e) {
    jQuery(e).is(":checked") ? jQuery("#the_champ_horizontal_sharing_options").css("display", "table-row-group") : jQuery("#the_champ_horizontal_sharing_options").css("display", "none")
}

function theChampVerticalSharingOptionsToggle(e) {
    jQuery(e).is(":checked") ? jQuery("#the_champ_vertical_sharing_options").css("display", "table-row-group") : jQuery("#the_champ_vertical_sharing_options").css("display", "none")
}

function theChampToggleOffset(e) {
    var t = "left" == e ? "right" : "left";
    jQuery("#the_champ_" + e + "_offset_rows").css("display", "table-row-group"), jQuery("#the_champ_" + t + "_offset_rows").css("display", "none")
}

function theChampSharingSizeValidate(e) {
    var t = parseInt(e.value.trim());
    t > 35 ? e.value = 35 : 16 > t && (e.value = 16)
}

function theChampSearchSharingNetworks(val) {
    jQuery('td.selectSharingNetworks label.lblSocialNetwork').each(function(){
        if (jQuery(this).text().toLowerCase().indexOf(val.toLowerCase()) != -1) {
            jQuery(this).parent().css('display', 'block');
        } else {
            jQuery(this).parent().css('display', 'none');
        }
    });
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

function heateorSsClearShareCountCache(){
    jQuery('#share_count_cache_loading').css('display', 'block');
    jQuery.ajax({
        type: 'GET',
        dataType: 'json',
        url: theChampSharingAjaxUrl,
        data: {
            action: 'heateor_ss_clear_share_count_cache'
        },
        success: function(data, textStatus, XMLHttpRequest){
            jQuery('#share_count_cache_loading').css('display', 'none');
            jQuery('#the_champ_share_count_cache_clear_message').css('display', 'block');
        }
    });
}

function theChampIncrement(e, t, r, a, i) {
    var h, s, c = !1,
        _ = a;
    s = function() {
        "add" == t ? r.value++ : "subtract" == t && r.value > 16 && r.value--, h = setTimeout(s, _), _ > 20 && (_ *= i), c || (document.onmouseup = function() {
            clearTimeout(h), document.onmouseup = null, c = !1, _ = a
        }, c = !0)
    }, e.onmousedown = s
}
function theChampUpdateSharingPreview(e, property, defaultVal, targetId) {
    if(!e){
        e = defaultVal;
    }
    jQuery('#' + targetId).css(property, e);
}
function theChampUpdateSharingPreviewHover(e, property, targetId) {
    var val = jQuery(e).val().trim();
    if(!val){
        jQuery('#' + targetId).hover(function(){
            jQuery(this).css(property, val);
        });
    }
}
function theChampSharingHorizontalPreview() {
    var tempBorderWidth = theChampBorderWidth ? theChampBorderWidth : '0px';
    if("rectangle" != tempHorShape){
        jQuery("#the_champ_preview").css({
            borderRadius: "round" == tempHorShape ? "999px" : theChampSharingBorderRadius ? theChampSharingBorderRadius : '0px',
            height: tempHorSize,
            width: tempHorSize,
            backgroundColor: theChampSharingBg,
            borderWidth: tempBorderWidth,
            borderColor: theChampBorderColor ? theChampBorderColor : 'transparent',
            borderStyle: 'solid',
        });
        tempHorSize = parseInt(tempHorSize);
        jQuery('.theChampCounterPreviewRight,.theChampCounterPreviewLeft').css({
            height: ( tempHorSize + 2*parseInt(tempBorderWidth) ) + 'px',
            lineHeight: ( tempHorSize + 2*parseInt(tempBorderWidth) ) + 'px'
        });
        jQuery('.theChampCounterPreviewInnerright,.theChampCounterPreviewInnerleft').css("lineHeight", tempHorSize + 'px');
        jQuery('.theChampCounterPreviewInnertop').css("lineHeight", (tempHorSize*38/100) + "px");
        jQuery('.theChampCounterPreviewInnerbottom').css("lineHeight", (tempHorSize*19/100) + "px");
        jQuery('.theChampCounterPreviewTop,.theChampCounterPreviewBottom').css({
            width: 60 + 2*parseInt(tempBorderWidth) + tempHorSize,
        });
    }else{
        jQuery("#the_champ_preview").css({
            borderRadius: theChampSharingBorderRadius ? theChampSharingBorderRadius : '0px',
            height: tempHorHeight,
            width: tempHorWidth,
            backgroundColor: theChampSharingBg,
            borderWidth: tempBorderWidth,
            borderColor: theChampBorderColor ? theChampBorderColor : 'transparent',
            borderStyle: 'solid'
        });
        jQuery('.theChampCounterPreviewRight,.theChampCounterPreviewLeft').css({
            height: ( parseInt(tempHorHeight) + 2*parseInt(tempBorderWidth) ) + 'px',
            lineHeight: ( parseInt(tempHorHeight) + 2*parseInt(tempBorderWidth) ) + 'px',
        });
        jQuery('.theChampCounterPreviewInnerright,.theChampCounterPreviewInnerleft').css('lineHeight', tempHorHeight + 'px');
        jQuery('.theChampCounterPreviewInnertop').css('lineHeight', (tempHorHeight*38/100) + 'px');
        jQuery('.theChampCounterPreviewInnerbottom').css('lineHeight', (tempHorHeight*19/100) + 'px');
        jQuery('.theChampCounterPreviewTop,.theChampCounterPreviewBottom').css({
            width: 60 + 2*parseInt(tempBorderWidth) + parseInt(tempHorWidth),
        });
    }

    jQuery("#the_champ_preview_message").css("display", "block")
}

function theChampSharingVerticalPreview() {
    var tempVerticalBorderWidth = theChampVerticalBorderWidth ? theChampVerticalBorderWidth : '0px';
    if("rectangle" != tempVerticalShape){
        jQuery("#the_champ_vertical_preview").css({
            borderRadius: "round" == tempVerticalShape ? "999px" : theChampVerticalBorderRadius ? theChampVerticalBorderRadius : '0px',
            height: tempVerticalSize,
            width: tempVerticalSize,
            backgroundColor: theChampVerticalSharingBg,
            borderWidth: tempVerticalBorderWidth,
            borderColor: theChampVerticalBorderColor ? theChampVerticalBorderColor : 'transparent',
            borderStyle: 'solid',
        });
        jQuery('.theChampCounterVerticalPreviewRight,.theChampCounterVerticalPreviewLeft').css({
            height: ( parseInt(tempVerticalSize) + 2*parseInt(tempVerticalBorderWidth) ) + 'px',
            lineHeight: ( parseInt(tempVerticalSize) + 2*parseInt(tempVerticalBorderWidth) ) + 'px',
        });
        jQuery('.theChampCounterVerticalPreviewInnerright,.theChampCounterVerticalPreviewInnerleft').css('lineHeight', tempVerticalSize + 'px');
        jQuery('.theChampCounterVerticalPreviewInnertop').css('lineHeight', (tempVerticalSize*38/100) + 'px');
        jQuery('.theChampCounterVerticalPreviewInnerbottom').css('lineHeight', (tempVerticalSize*19/100) + 'px');
        jQuery('.theChampCounterVerticalPreviewTop,.theChampCounterVerticalPreviewBottom').css({
            width: 60 + 2*parseInt(tempVerticalBorderWidth) + parseInt(tempVerticalSize)
        });
    }else{
        jQuery("#the_champ_vertical_preview").css({
            borderRadius: theChampVerticalBorderRadius ? theChampVerticalBorderRadius : '0px',
            height: tempVerticalHeight,
            width: tempVerticalWidth,
            backgroundColor: theChampVerticalSharingBg,
            borderWidth: tempVerticalBorderWidth,
            borderColor: theChampVerticalBorderColor ? theChampVerticalBorderColor : 'transparent',
            borderStyle: 'solid'
        });
        jQuery('.theChampCounterVerticalPreviewRight,.theChampCounterVerticalPreviewLeft').css({
            height: ( parseInt(tempVerticalHeight) + 2*parseInt(tempVerticalBorderWidth) ) + 'px',
            lineHeight: ( parseInt(tempVerticalHeight) + 2*parseInt(tempVerticalBorderWidth) ) + 'px',
        });
        jQuery('.theChampCounterVerticalPreviewInnerright,.theChampCounterVerticalPreviewInnerleft').css('lineHeight', tempVerticalHeight + 'px');
        jQuery('.theChampCounterVerticalPreviewInnertop').css('lineHeight', (tempVerticalHeight*38/100) + 'px');
        jQuery('.theChampCounterVerticalPreviewInnerbottom').css('lineHeight', (tempVerticalHeight*19/100) + 'px');
        jQuery('.theChampCounterVerticalPreviewTop,.theChampCounterVerticalPreviewBottom').css({
            width: 60 + 2*parseInt(tempVerticalBorderWidth) + parseInt(tempVerticalWidth),
        });
    }
    jQuery("#the_champ_vertical_preview_message").css("display", "block")
}

function theChampCounterPreview(val){
    if(val){
        jQuery('input[name="the_champ_sharing[horizontal_counter_position]"]').each(function(){
            if(jQuery(this).val().indexOf('inner') == -1){
                var property = 'visibility', value = 'visible', inverseValue = 'hidden';
                jQuery('#horizontal_svg').css({
                    'width': '100%',
                    'height':'100%'
                });
            }else{
                var property = 'display', value = 'block', inverseValue = 'none';
            }
            if(jQuery(this).val() == val){
               jQuery('.theChampCounterPreview' + theChampCapitaliseFirstLetter(val.replace('_',''))).css(property, value); 
            }else{
                jQuery('.theChampCounterPreview' + theChampCapitaliseFirstLetter(jQuery(this).val().replace('_',''))).css(property, inverseValue);
            }
        });

        if(val == 'inner_left' || val == 'inner_right'){
            jQuery('#horizontal_svg').css({
                'width': '50%',
                'height':'100%'
            });
        }else if(val == 'inner_top' || val == 'inner_bottom'){
            jQuery('#horizontal_svg').css({
                'width': '100%',
                'height':'70%'
            });
        }
    }
}

function theChampVerticalCounterPreview(val){
    if(val){
        jQuery('input[name="the_champ_sharing[vertical_counter_position]"]').each(function(){
            if(jQuery(this).val().indexOf('inner') == -1){
                var property = 'visibility', value = 'visible', inverseValue = 'hidden';
                jQuery('#vertical_svg').css({
                    'width': '100%',
                    'height':'100%'
                });
            }else{
                var property = 'display', value = 'block', inverseValue = 'none';
            }
            if(jQuery(this).val() == val){
               jQuery('.theChampCounterVerticalPreview' + theChampCapitaliseFirstLetter(val.replace('_',''))).css(property, value); 
            }else{
                jQuery('.theChampCounterVerticalPreview' + theChampCapitaliseFirstLetter(jQuery(this).val().replace('_',''))).css(property, inverseValue);
            }
            if(val == 'inner_left' || val == 'inner_right'){
                jQuery('#vertical_svg').css({
                    'width': '50%',
                    'height':'100%'
                });
            }else if(val == 'inner_top' || val == 'inner_bottom'){
                jQuery('#vertical_svg').css({
                    'width': '100%',
                    'height':'70%'
                });
            }
        });
    }
}
"function" != typeof String.prototype.trim && (String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, "")
}), jQuery(document).ready(function() {
    // instagram username option
    jQuery('input#the_champ_instagram').click(function(){
        if(jQuery(this).is(':checked')){
            jQuery('#the_champ_instagram_options').css('display', 'table-row-group');
        }else{
            jQuery('#the_champ_instagram_options').css('display', 'none');
        }
    });
    jQuery('input#the_champ_vertical_sharing_instagram').click(function(){
        if(jQuery(this).is(':checked')){
            jQuery('#the_champ_vertical_instagram_options').css('display', 'table-row-group');
        }else{
            jQuery('#the_champ_vertical_instagram_options').css('display', 'none');
        }
    });
    jQuery('input#the_champ_vertical_instagram_username').keyup(function(){
        jQuery('#the_champ_instagram_username').val(jQuery(this).val().trim());
    });
    jQuery('input#the_champ_instagram_username').keyup(function(){
        jQuery('#the_champ_vertical_instagram_username').val(jQuery(this).val().trim());
    });
    // sharing master conrol
    jQuery('input#the_champ_enable_sharing').click(function(){
        if(jQuery(this).is(':checked')){
            jQuery('div#tabs').css('display', 'block');
        }else{
            jQuery('div#tabs').css('display', 'none');
        }
    });
    // Twitter share count options
    jQuery('input#the_champ_vertical_newsharecounts').click(function(){
        jQuery('#the_champ_newsharecounts').attr('checked', 'checked');
    });
    jQuery('input#the_champ_vertical_opensharecount').click(function(){
        jQuery('#the_champ_opensharecount').attr('checked', 'checked');
    });
    jQuery('input#the_champ_newsharecounts').click(function(){
        jQuery('#the_champ_vertical_newsharecounts').attr('checked', 'checked');
    });
    jQuery('input#the_champ_opensharecount').click(function(){
        jQuery('#the_champ_vertical_opensharecount').attr('checked', 'checked');
    });
    jQuery('input#the_champ_counts').click(function(){
        if(jQuery(this).is(':checked')){
            jQuery('#the_champ_twitter_share_count').css('display', 'table-row');
        }else{
            jQuery('#the_champ_twitter_share_count').css('display', 'none');
        }
    });
    jQuery('input#the_champ_vertical_counts').click(function(){
        if(jQuery(this).is(':checked')){
            jQuery('#the_champ_twitter_vertical_share_count').css('display', 'table-row');
        }else{
            jQuery('#the_champ_twitter_vertical_share_count').css('display', 'none');
        }
    });
    jQuery('input[name="the_champ_sharing[horizontal_sharing_shape]"]').click(function(){
        // toggle height, width options
        if(jQuery(this).val() == 'rectangle'){
            jQuery('#the_champ_rectangle_options').css('display', 'table-row-group');
            jQuery('#the_champ_size_options').css('display', 'none');
        }else{
            jQuery('#the_champ_rectangle_options').css('display', 'none');
            jQuery('#the_champ_size_options').css('display', 'table-row-group');
        }

        // toggle border radius option
        if(jQuery(this).val() == 'round'){
            jQuery('#the_champ_border_radius_options').css('display', 'none');
        }else{
            jQuery('#the_champ_border_radius_options').css('display', 'table-row-group');
        }
    });
    jQuery('input#the_champ_mobile_sharing_bottom').click(function(){
        if(jQuery(this).is(':checked')){
            jQuery('#the_champ_bottom_sharing_options').css('display', 'table-row-group');
        }else{
            jQuery('#the_champ_bottom_sharing_options').css('display', 'none');
        }
    });
    jQuery('input[name="the_champ_sharing[vertical_sharing_shape]"]').click(function(){
        // toggle height, width options
        if(jQuery(this).val() == 'rectangle'){
            jQuery('#the_champ_vertical_rectangle_options').css('display', 'table-row-group');
            jQuery('#the_champ_vertical_size_options').css('display', 'none');
        }else{
            jQuery('#the_champ_vertical_rectangle_options').css('display', 'none');
            jQuery('#the_champ_vertical_size_options').css('display', 'table-row-group');
        }

        // toggle border radius option
        if(jQuery(this).val() == 'round'){
            jQuery('#the_champ_vertical_border_radius_options').css('display', 'none');
        }else{
            jQuery('#the_champ_vertical_border_radius_options').css('display', 'table-row-group');
        }
    });
    jQuery("#the_champ_ss_rearrange, #the_champ_ss_vertical_rearrange").sortable(), jQuery(".theChampHorizontalSharingProviderContainer input").click(function() {
        jQuery(this).is(":checked") ? jQuery("#the_champ_ss_rearrange").append('<li title="' + jQuery(this).val().replace(/_/g, " ") + '" id="the_champ_re_horizontal_' + jQuery(this).val().replace(/[. ]/g, "_") + '" ><i style="display:block;' + theChampHorSharingStyle + '" class="' + ( jQuery.inArray(jQuery(this).val(), theChampLikeButtons) != -1 ? '' : 'theChampSharingBackground ' ) + 'theChamp' + theChampCapitaliseFirstLetter(jQuery(this).val().replace(/[_. ]/g, "")) + 'Background"><div class="theChampSharingSvg theChamp' + theChampCapitaliseFirstLetter(jQuery(this).val().replace(/[_. ]/g, "")) + 'Svg" style="' + theChampHorDeliciousRadius + '"></div></i><input type="hidden" name="the_champ_sharing[horizontal_re_providers][]" value="' + jQuery(this).val() + '"></li>') : jQuery("#the_champ_re_horizontal_" + jQuery(this).val().replace(/[. ]/g, "_")).remove()
    }), jQuery(".theChampVerticalSharingProviderContainer input").click(function() {
        jQuery(this).is(":checked") ? jQuery("#the_champ_ss_vertical_rearrange").append('<li title="' + jQuery(this).val().replace(/_/g, " ") + '" id="the_champ_re_vertical_' + jQuery(this).val().replace(/[. ]/g, "_") + '" ><i style="display:block;' + theChampVerticalSharingStyle + '" class="' + ( jQuery.inArray(jQuery(this).val(), theChampLikeButtons) != -1 ? '' : 'theChampVerticalSharingBackground ' ) + 'theChamp' + theChampCapitaliseFirstLetter(jQuery(this).val().replace(/[_. ]/g, "")) + 'Background"><div class="theChampSharingSvg theChamp' + theChampCapitaliseFirstLetter(jQuery(this).val().replace(/[_. ]/g, "")) + 'Svg" style="' + theChampVerticalDeliciousRadius + '"></div></i><input type="hidden" name="the_champ_sharing[vertical_re_providers][]" value="' + jQuery(this).val() + '"></li>') : jQuery("#the_champ_re_vertical_" + jQuery(this).val().replace(/[. ]/g, "_")).remove()
    }), jQuery("#the_champ_target_url_column").find("input[type=radio]").click(function() {
        jQuery(this).attr("id") && "the_champ_target_url_custom" == jQuery(this).attr("id") ? jQuery("#the_champ_target_url_custom_url").css("display", "block") : jQuery("#the_champ_target_url_custom_url").css("display", "none")
    }), jQuery("#the_champ_vertical_target_url_column").find("input[type=radio]").click(function() {
        jQuery(this).attr("id") && "the_champ_vertical_target_url_custom" == jQuery(this).attr("id") ? jQuery("#the_champ_vertical_target_url_custom_url").css("display", "block") : jQuery("#the_champ_vertical_target_url_custom_url").css("display", "none")
    }), jQuery("#the_champ_target_url_custom").is(":checked") ? jQuery("#the_champ_target_url_custom_url").css("display", "block") : jQuery("#the_champ_target_url_custom_url").css("display", "none"), jQuery("#the_champ_vertical_target_url_custom").is(":checked") ? jQuery("#the_champ_vertical_target_url_custom_url").css("display", "block") : jQuery("#the_champ_vertical_target_url_custom_url").css("display", "none")
})