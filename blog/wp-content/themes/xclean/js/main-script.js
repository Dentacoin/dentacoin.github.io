;( function( $ ) {
  $( document ).ready( function( $ ) {
    /*====================================
    =            Fixed Header            =
    ====================================*/

    var shrinkHeader = 80;
    $( window ).scroll( function() {
      var scroll = getCurrentScroll();
      if ( scroll >= shrinkHeader ) {
        $( '.header' ).addClass( 'fixed-header' );
      }
      else {
        $( '.header' ).removeClass( 'fixed-header' );
      }
    } );
    function getCurrentScroll() {
      return window.pageYOffset || document.documentElement.scrollTop;
    }

    /*=====  End of Fixed Header  ======*/

    /*=============================================
    =            Mobile menu accordion            =
    =============================================*/

    if( $( window ).width() < 767 ) {
      $( '.menu-item-has-children>a' ).click( function( e ) {
        e.preventDefault();
        if ( $( this ).parent( 'li' ).hasClass( 'active' ) ) {
          $( this ).parent( 'li').removeClass( 'active' );
          $( this ).parent( 'li' ).children( 'ul' ).slideUp( 'normal' );
        } else {
          $( this ).parent( 'li' ).addClass( 'active' );
          $( this ).parent( 'li' ).children( 'ul' ).slideDown( 'normal' );
        }
      } );
    }
    /*=====  End of Mobile menu accordion  ======*/

    /*====================================
    =            Search PopUp            =
    ====================================*/

    $( '.header-search img' ).click( function( e ) {
      $( '.search-inside' ).fadeIn( 250 );
      $( '.search-inside form' ).removeClass( 'transform-out' ).addClass( 'transform-in' );

      e.preventDefault();
    } );

    $( '.search-inside i' ).click( function( e ) {
      $( '.search-inside' ).fadeOut( 500 );
      $( '.search-inside form' ).removeClass( 'transform-in' ).addClass( 'transform-out' );

      e.preventDefault();
    } );


    $( '.header-search img' ).click( function() {
      if ( $ ( '.searchform' ).hasClass( 'transform-in' ) ) {
        $( '.header-search' ).addClass( 'popup-woo' );
      }
    } );
    $( '.header-search .search-inside i' ).click( function() {
      if ( $ ( '.searchform' ).hasClass( 'transform-out' ) ) {
        $( '.header-search' ).removeClass( 'popup-woo' );
      }
    } );
    /*=====  End of Search PopUp  ======*/

  } );
} )( jQuery );
