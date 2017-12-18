
$(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});

$(document).ready(function(){
    $(".register").click(function(){
        $("div#register").hide();
        $("div#login").show();
        $("#form-login").hide();
        $("#form-register").show();
        $("h3").html("Already have an account?");
    });
    
    
    $(".login").click(function(){
        $("div#login").hide();
        $("div#register").show();
        $("#form-register").hide();
        $("#form-login").show();
        $("h3").html("New to Pioneer?");
    });
    
});