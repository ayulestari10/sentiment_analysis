  jQuery(document).ready(function() {
    jQuery(window).scroll(function() {
      if ( jQuery(window).width() > 768) {
        if (jQuery(window).scrollTop() >= 100) {
            jQuery('#mainnav').css('padding', '5').css('background-color','rgb(40,40,40)');
             } else {
            jQuery('#mainnav').css('padding', '20px 0').css('background-color','transparent');
             }
      }
    });
 });


// source : https://codepen.io/fooby/pen/YWXLxr?editors=0010
$(document).ready(function(){
  $('a[href^="#"]').on('click',function (e) {
      e.preventDefault();

      var target = this.hash;
      var $target = $(target);

      $('html, body').stop().animate({
          'scrollTop': $target.offset().top
      }, 900, 'swing', function () {
          window.location.hash = target;
      });
  });
});

// corousel about
$(document).ready(function() {
  $('#Carousel').carousel({
    interval: 5000
  })
});