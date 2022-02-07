// JavaScript Document

// VARIABLES

var sc = 0,
    ww = window.innerWidth,
	wh = window.innerHeight;


// LIBRARIES

import $ from 'jquery'
// import balanceText from 'balance-text'
// import fancybox from '@fancyapps/fancybox'
// import { tns } from 'tiny-slider/src/tiny-slider'
// import { fitVids } from './jquery.fitvids.js'


// LISTENERS

$(document).ready(function(){
	resize();
    
    loadImages();
    
    // BALANCE TEXT
    // if($('.balance').length>0)   balanceText($('.balance'),{watch: true});
    // if($('.balance *').length>0) balanceText($('.balance *'),{watch: true});
    
    // FITVIDS
    // $('iframe[src*="youtube"]').parent().fitVids();
    
	// FORM
	// if($('input').length>0){
	// 	$('input').each(function(){
	// 		var $this = $(this);
	// 		
	// 		$this.blur(function(){
	// 			if($this.val()==''){
	// 				$this.removeClass('filled');
	// 			}else{
	// 				$this.addClass('filled');
	// 			}
	// 		});
	// 	});
	// }
});

window.onresize = resize;
window.onscroll = scroll;

// FUNCTIONS

function resize(){
	ww = window.innerWidth;
	wh = window.innerHeight;
}


function scroll(){
	sc = getScrollOffsets();
    
    loadImages();
}

function getScrollOffsets() {
    if ( window.pageXOffset != null ) { 
        return window.pageYOffset
    }
 
    var doc = window.document;
 
    if ( document.compatMode === "CSS1Compat" ) {
        return doc.documentElement.scrollTop
    }
 
    return doc.body.scrollTop;
}

function loadImages(){
	
	var $bg_images = $('[data-bg]');
	
	$bg_images.each(function(){
		var $this = $(this),
			this_offset = $this.offset().top,
			this_height = $this.outerHeight(),
			this_image = $this.data('bg');
		
		if(((sc+wh)>this_offset) && (sc<(this_offset+this_height))){
			$this.css('background-image','url(\''+this_image+'\')');
			$this.removeAttr('data-bg');
		}
	});
	
	var $img_images = $('[data-img]');
	
	$img_images.each(function(){
		var $this = $(this),
			this_offset = $this.offset().top,
			this_height = $this.outerHeight(),
			this_image = $this.data('img');
		
		if(((sc+wh)>this_offset) && (sc<(this_offset+this_height))){
			$this.attr('src',this_image);
			$this.removeAttr('data-img');
		}
	});
}