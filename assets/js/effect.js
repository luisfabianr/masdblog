
jQuery(document).ready(function($) { 

var searchVisible = 0;
var transparent = true;

var transparentDemo = true;
var fixedTop = false;

var navbar_initialized = false;

var big_image; 
var scroll;
var project_content;
var $project;
scroll = ( 5100 - $(window).width() ) / $(window).width();

var $ScrollTop;
var $ScrollBot;

var pixels;

var modal;
var $project_content;

var test = true;        

var timerStart = Date.now();
var delay;

var no_of_elements = 0;
var window_height;
var window_width;

var content_opacity = 0;
var content_transition = 0;
var no_touch_screen = false;

var burger_menu;

        
$(document).ready(function(){

    jQuery( '#sharing' ).html( jQuery( '.sharedaddy' ).detach() );

    
    $('.show').click(function () {
        $('#discussion' + $(this).attr('target')).toggle().siblings('.targetDiv').hide() ;
        $('a.show').removeClass("active");
        $(this).addClass("active");
    });


    BrowserDetect.init();
    
    if(BrowserDetect.browser == 'Explorer' && BrowserDetect.version <= 9){
        $('body').html(better_browser);   
    }

    window_width = $(window).width();
    window_height = $(window).height();

    burger_menu = $('nav').hasClass('navbar-burger') ? true : false;
    
    if (!Modernizr.touch){
        $('body').addClass('no-touch');
        no_touch_screen = true;
    }
    
    rubik.initAnimationsCheck();
    
    // Init navigation toggle for small screens   
    if(window_width < 992 || burger_menu){
        rubik.initRightMenu();   
    }

    if(window_width < 992){
        $('.over-area').each(function(){
            var click = $(this).attr("onClick");
            if(click == ''){
                src = "rubik.showModal(this)";
                $(this).attr("onClick", src);
            }
        });
        
        rubik.checkResponsiveImage();
    } 
    
    setTimeout(function(){
         $('.loading').css('opacity','0');
         setTimeout(function(){
             $('.loading').addClass('hide');
         }, 500);
     }, 3000);
        
    
    if($('#contactUsMap').length != 0){
        rubik.initGoogleMaps();   
    }
    
    if($('.content-with-opacity').length != 0){
        content_opacity = 1;
    }

});


$(window).load(function(){
    
    //after the content is loaded we reinitialize all the waypoints for the animations
    rubik.initAnimationsCheck();
    
});  
  
rubik = {
    misc:{
        navbar_menu_visible: 0
    },
    initAnimationsCheck: function(){
        $('[class*="add-animation"]').each(function(){
           offset_diff = 30;
           if($(this).hasClass('title')){
               offset_diff = 110;
           }
           
           var waypoints = $(this).waypoint(function(direction) {
                if(direction == 'down'){
                        $(this.element).addClass('animate');    
                   } else {
                       $(this.element).removeClass('animate');
                   }
                }, {
                  offset: window_height - offset_diff
           });
        });
  
    },

    checkScrollForTransparentNavbar: debounce(function() {	
        	if($(document).scrollTop() > 560 ) {
                if(transparent) {
                    transparent = false;
                    $('nav[role="navigation"]').removeClass('navbar-transparent');
                }
            } else {
                if( !transparent ) {
                    transparent = true;
                    $('nav[role="navigation"]').addClass('navbar-transparent');
                }
            }
    }, 17),
    
    checkScrollForParallax: debounce(function() {	
        	no_of_elements = 0;
        	$('.parallax').each(function() {
        	    var $elem = $(this);
        	    
        	    if(isElementInViewport($elem)){
                  var parent_top = $elem.offset().top;          
                  var window_bottom = $(window).scrollTop();
                  var $image = $elem.children('img');
                              	  
            	  oVal = ((window_bottom - parent_top) / 3);
                  $image.css('transform','translate3d(0px, ' + oVal + 'px, 0px)');    
        	    }
            });
    		
    }, 6),
    
    
    
    
    


}

// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.

function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		}, wait);
		if (immediate && !timeout) func.apply(context, args);
	};
};


function isElementInViewport(elem) {
    var $elem = $(elem);

    // Get the scroll position of the page.
    var scrollElem = ((navigator.userAgent.toLowerCase().indexOf('webkit') != -1) ? 'body' : 'html');
    var viewportTop = $(scrollElem).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    // Get the position of the element on the page.
    var elemTop = Math.round( $elem.offset().top );
    var elemBottom = elemTop + $elem.height();

    return ((elemTop < viewportBottom) && (elemBottom > viewportTop));
}


var BrowserDetect = {
    init: function () {
        this.browser = this.searchString(this.dataBrowser) || "Other";
        this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
    },
    searchString: function (data) {
        for (var i = 0; i < data.length; i++) {
            var dataString = data[i].string;
            this.versionSearchString = data[i].subString;

            if (dataString.indexOf(data[i].subString) !== -1) {
                return data[i].identity;
            }
        }
    },
    searchVersion: function (dataString) {
        var index = dataString.indexOf(this.versionSearchString);
        if (index === -1) {
            return;
        }

        var rv = dataString.indexOf("rv:");
        if (this.versionSearchString === "Trident" && rv !== -1) {
            return parseFloat(dataString.substring(rv + 3));
        } else {
            return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
        }
    },

    dataBrowser: [
        {string: navigator.userAgent, subString: "Chrome", identity: "Chrome"},
        {string: navigator.userAgent, subString: "MSIE", identity: "Explorer"},
        {string: navigator.userAgent, subString: "Trident", identity: "Explorer"},
        {string: navigator.userAgent, subString: "Firefox", identity: "Firefox"},
        {string: navigator.userAgent, subString: "Safari", identity: "Safari"},
        {string: navigator.userAgent, subString: "Opera", identity: "Opera"}
    ]

};
 });
