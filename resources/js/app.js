// JavaScript Document

// VARIABLES

var ww = window.innerWidth,
	wh = window.innerHeight;


// LIBRARIES

import $ from 'jquery'
//import { tns } from 'tiny-slider/src/tiny-slider'


// LISTENERS

$(document).ready(function(){
	resize();
});

window.onresize = resize;
window.onscroll = scroll;


// SMOOTHSCROLL

$(document).ready( smoothscroll );

function smoothscroll(time){
	if(!time) time = 1000;
	$('a[href]').each(function(){
		var e = $(this), id = e.attr('href');
		if(!e.parent().hasClass('no-scroll') && !e.hasClass('no-scroll')){
			if(id[0]=='#'){
				e.attr('href','javascript:void(0)');
				e.click(function(){ smoothscrollto(id,time,0); });
			}
		}
	});
}

export default function smoothscrollto(id,time,margin){
	var p;
	console.log(id);
	if(id=='#'){
		p = 0;
	}else{
		var e = $(id);
		p = e.offset().top;
	}
	console.log(p);
	$('html, body').animate({ scrollTop: (p+margin) },time);
}


// FUNCTIONS


function resize(){
	ww = window.innerWidth;
	wh = window.innerHeight;
}


function scroll(){
	sc = getScrollOffsets();
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
	
	// LOAD IMAGES
	
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