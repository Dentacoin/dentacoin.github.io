/* RowScroll 1.1.1 copyright 2015 Eric Butler, licensed under GNU GPLv2, free for personal and commercial use */


// add easing function:
$.extend($.easing,{eoq:function(n,e,i,u,s){return-u*(e/=s)*(e-2)+i}});


$(document).ready(function(){

  var scrollTargets = $('.scroll-target'), // selectors to include in the auto-scroll sequence
      scrollTops = [],
      wiggleRoom = 10, // amount of px to add to/subtract from scroll tops when evaluating where to scroll to
      scrollSpeed = 400, // amount of milliseconds to take to get to the next/previous scroll target
      totalScrollTargets = scrollTargets.length, // get total count of how many scroll targets there are
      lasttmX = 0, // (used in touchmove event handler)
      lasttmY = 0; // (used in touchmove event handler)


  // on page load, get a list of all divs with a "scroll-target" class, and their scroll-to locations
  function getScrollTops () {
    scrollTargets.each(function(){
      scrollTops.push( Math.ceil( $(this).offset().top ) );
    }); // end each
  } // end getScrollTops function definition


  // animate the window's scrollTop to the top of the target element
  function autoScrollTo (targetEl) {
    $('html, body')
      .stop()
      .animate(
        { scrollTop: $(targetEl).offset().top }, // move window so target element is at top of window
        scrollSpeed, // speed in milliseconds
        'eoq' // easing
      ); // end animate
  } // end autoScrollTo function definition


  function processScroll (e) {

    // get the current scroll position on the page
    var scrollPosition = window.scrollY;


    // determine the scroll direction
    if ( e.deltaY > 0 ) { var scrollDirection = 'up'; }
    else if ( e.deltaY <= 0 ) { var scrollDirection = 'down'; }

    // if the scroll is downward,
    if (scrollDirection == 'down') {

      // compare all the scroll targets's scrollTops to the current scroll position
      for ( var i = 0; i < totalScrollTargets; i++ ) {

        // if the current scroll position is between the top offsets of this and the next div
        if ( scrollPosition >= (scrollTops[i] - wiggleRoom) && scrollPosition < (scrollTops[i+1] - wiggleRoom) ) {

          // auto-scroll to the i+1 (the next) div's offset top
          autoScrollTo(scrollTargets[i+1]);

          break; // stop looping

        } // end if

      } // end for

    } // end if scrollDirection is down


    // else if the scroll is upward,
    else if (scrollDirection == 'up') {

      for ( var i = 0; i < totalScrollTargets; i++ ) {

        // if the current scroll position is less than or equal to the next div's top offset 
        // AND greater than the current div's top offset
        if ( scrollPosition <= (scrollTops[i+1] + wiggleRoom) && scrollPosition > (scrollTops[i] + wiggleRoom) ) {

          autoScrollTo(scrollTargets[i]);

          break;

        } // end if

      } // end for

    } // end else if scrollDirection is up

    return false;

  } // end processScroll function definition


  // only proceed if there are some scroll targets on the page
  if ( totalScrollTargets > 0 ) {

    getScrollTops();


    // re-get the list if the window size changes
    $(window).on('resize', function () {
      // delete the existing scroll-to locations
      scrollTops.length = 0;
      // get a fresh list of all the scroll-to locations
      getScrollTops();
    }); // end on resize


    // handle a mousewheel or trackpad scroll
    $(window).on('mousewheel', function (e) {
      e.preventDefault(); // prevent natural page scroll
      processScroll(e);
    }); // end on mousewheel


    // detect the touchstart x- and y-value
    $(window).on('touchstart', function (e) {
      tsX = e.originalEvent.touches[0].clientX;
      tsY = e.originalEvent.touches[0].clientY;
    }); // end on touchstart


    // detect the touchmove x- and y-values and maybe hijack vertical scrolling
    $(window).on('touchmove', function (e) {
      tmX = e.originalEvent.changedTouches[0].clientX;
      tmY = e.originalEvent.changedTouches[0].clientY;
      // if this is the first touchmove event, or
      // if there's been over 1px of vertical movement since the last event,
      // prevent page scroll
      // -- but first check if the scroll is horizontal
      if ( Math.abs(lasttmX - tmX) > 30 && Math.abs(lasttmY - tmY) < 5 ) {
        // do nothing, user is scrolling horizontally
      } else if ( lasttmY == 0 || Math.abs(lasttmY - tmY) > 1 ) {
        e.preventDefault(); // prevent natural page scroll
      } // end if
      lasttmX = tmX; // remember what this touchmove's x-value is, for next time
      lasttmY = tmY; // remember what this touchmove's y-value is, for next time
    }); // end on touchmove


    // detect the touchend x- and y-value and handle a mobile swipe
    // (the 50px ensures that horizontal scrolls don't accidentally trigger the processScroll function)
    $(window).on('touchend', function (e) {
      teX = e.originalEvent.changedTouches[0].clientX;
      teY = e.originalEvent.changedTouches[0].clientY;
      if ( Math.abs(tsX - teX) > 50 ) {
        return true;
      } else if (tsY > teY + 5) {
        e.deltaY = -1; // is moving down
      } else if (tsY < teY - 5) {
        e.deltaY = 1; // is moving up
      } else {
        return true;
      } // end else
      e.preventDefault(); // prevent natural page scroll
      processScroll(e);
    }); // end on touchend


  } // end if totalScrollTargets > 0

}); // end document ready
