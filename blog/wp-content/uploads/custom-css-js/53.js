<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
(function($){
      
  $(window).on('load resize', function() {

    if( !$('body').hasClass('home') ){

      var reducer     = 100; /* in pixel */
      var slideHeight = $('#slideshow').height();
      var newHeight   = slideHeight-reducer;
      
      $('#slideshow').height(newHeight);
      
    }
    
  });

})(jQuery);
</script><!-- end Simple Custom CSS and JS -->
