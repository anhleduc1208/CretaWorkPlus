(function ($) {
  "use strict";

  //Navigation Menu dropdown Focused

  var $openClass = "open open-position";
  var $hasChildren = "menu-item-has-children";

  if ($hasChildren.length > 0) {
    jQuery(".navbar").on("focusin", "." + $hasChildren, function () {
      jQuery(this).addClass($openClass);

    });
    jQuery(".navbar").on("focusout", "." + $hasChildren, function () {
      jQuery(this).removeClass($openClass);
    });
  }
  //scroll to top
    jQuery("#back-top").hide();
    jQuery("#back-top").on("click",function(e) {
      e.preventDefault();
      jQuery("html, body").animate({ scrollTop: 0 }, "slow");
    });

    jQuery(window).scroll(function(){
      var scrollheight =400;
      if( $(window).scrollTop() > scrollheight ) {
        jQuery("#back-top").fadeIn();
        jQuery("#back-top").addClass("scroll-visible");
      }
      else {
        jQuery("#back-top").fadeOut();
        jQuery("#back-top").removeClass("scroll-visible");
      }
    });
    
    jQuery("a[href*=#]").click(function(event){     
        event.preventDefault();
        jQuery('html,body').animate({scrollTop:jQuery(this.hash).offset().top}, 500);
    });
})(jQuery);
