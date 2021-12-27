jQuery('#header-part a.mobilemenu').click(function(){
    jQuery(this).toggleClass('active'); 
    jQuery('body').toggleClass('active'); 
    jQuery('#header-part .menu-bar').slideToggle();
});

jQuery('.destinations-bar h3').click(function(){
    jQuery(this).toggleClass('active'); 
    jQuery('.destinations-bar .row').slideToggle();
});

