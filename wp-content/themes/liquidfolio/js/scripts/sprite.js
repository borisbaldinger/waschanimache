// last updated 2013-03-21 14:35:16

// file contactForm.js start

try { 
jQuery(function(){
	// Form styles
	jQuery('select').wrap('<div class="styled-select" />');
});

function ajaxContact(theForm) {
	var $ = jQuery;
	var name, el, label, html;
	var form_data = {};
	jQuery('input, select, textarea', theForm).each(function(n, element) {
		el =  jQuery(element);
//		if(el.is('input') || el.is('textarea') || el.is('select'))
		{
			name = el.attr('name');
//
			switch(el.attr('type'))
			{
				case 'radio':
					if(el.prop('checked'))
					{
						label = jQuery('label:first', el.parent('div'));
					}
					break;
				case 'checkbox':
					label = jQuery("label[for='"+name+"']:not(.error)", theForm);
					break;
				default:
					label = jQuery("label[for='"+name+"']", theForm);
			}

			if( !(jQuery(theForm).hasClass('contactformWidget')) && label && label.length)
			{
				html = label.html();
				html = html.replace(/<span>.*<\/span>/,'');
				html = html.replace(/<br>/,'');
				if(el.attr('type') == 'checkbox')
				{
					if(el.prop('checked'))
					{
						form_data[html] = 'yes';
					}
					else
					{
						form_data[html] = 'no';
					}
				}
				else
				{
					form_data[html] = el.val().replace(/\n/g, '<br/>');
				}
			}
			else
			{
				/**
				 * to, subject .....
				 */
				if(name != undefined && name != '_wp_http_referer' && name != '_wpnonce' && name !='contact-form-id' && name != 'validate_rules')
				{
					if(el.attr('type') != 'radio')
					{
						/**
						 * email reply to:
						 */
						if(name == 'qd-email-from')
						{
							if( form_data[name] == undefined)
							{
								/**
								 * first of reply
								 */
								var email_id = email_from = null;
								jQuery('[name="'+name+'"]').each(function()
								{
									email_id = jQuery(this).val();
									email_from = jQuery('#'+email_id, theForm).val();
									if(email_from && email_from.length)
									{
										return false;
									}
								});

								if(email_from && email_from.length)
								{
									form_data[name] = email_from ;
								}
							}
						}
						else
						{
							form_data[name] = el.val();
						}
					}
				}
			}
			name = label = html= null;
		}
		el = null;
	});

	form_data.action = 'send_contact_form'

	jQuery.ajax({
		type: "POST",
		url: theme.ajaxurl,
		data: form_data,
		//dataType: 'json',
		success: function(response) {

			jQuery(theForm).find('div').fadeOut(500);
			setTimeout(function() {
				if (response === 'success') {
					jQuery(theForm).append('<p class="note">Your message has been successfully sent to us!</p>').slideDown('fast'); //success text
				} else {
					jQuery(theForm).append('<p class="note">Something going wrong with sending mail...</p>').slideDown('fast');	// error text when php mail() function failed
				}
			},500);


			setTimeout(function() {
				jQuery(theForm).find('.note').html('').slideUp('fast');
				jQuery(theForm).find("button, .lf_button").removeAttr('disabled');
				jQuery(theForm).find("input[type=text], textarea").val('');
				jQuery(theForm).find('div').fadeIn(500);
			},3000);
		},
		error: function(response) {

			jQuery(theForm).find('div').fadeOut(500);
			setTimeout(function() {
				jQuery(theForm).append('<p class="note">Something going wrong with connection...</p>').fadeIn(500); //error text when ajax didn't send data to php processor
			},500);
			setTimeout(function() {
				jQuery(theForm).find('.note').html('').slideUp('fast');
				jQuery(theForm).find("button, .qd_button").removeAttr('disabled');
				jQuery(theForm).find("input[type=text], textarea").val('');
				jQuery(theForm).find('div').fadeIn(500);
			},3000);

		}


	});

	return false;
}
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file contactForm.js'); }

// file contactForm.js end

// file lightbox.js start

try { 
jQuery(window).load(function() {
	jQuery('article.gallery_listing').click(function(){
		var other_id, post_id;
		// list of visible gallery posts
		var id_list = new Array();
		//current gallery post
		post_id = getID(this);
		if (jQuery(this).data('lightbox')) {
			if(post_id !== false)
			{
				jQuery('.gallery_listing').each(function(){
					var opacity = parseInt(jQuery(this).css('opacity'));
					if(opacity) {
						other_id = getID(this);
						if(other_id !== false) {
							id_list.push(other_id);
						}
					}
				});
				var data = {
					current:	post_id,
					list:		id_list,
					lightbox:	jQuery(this).data('lightbox'),
					gallery_page_id : jQuery(this).children('a:first').data('gallery_page_id')
				};
				openLightbox(data);
			}
			return false;
		}
	});

	jQuery('.flex-post-nav .flex-prev').live('click', function(){
		var gallery_single = jQuery('.gallery_single');
		var id_list = gallery_single.data('list');
		galleryIterator.init(
			gallery_single.data('current'),
			id_list
		);

		var data = {
			current:	galleryIterator.getPrev(),
			list:		id_list,
			gallery_page_id: gallery_single.children('.gallery_left').data('gallery_page_id'),
			lightbox:	'fullscreen'
		};
		openLightbox(data);

		return false;
	});

	jQuery('.flex-post-nav .flex-next').live('click', function(){
		var gallery_single = jQuery('.gallery_single');
		var id_list = gallery_single.data('list');
		galleryIterator.init(
			gallery_single.data('current'),
			id_list
		);

		var data = {
			current:	galleryIterator.getNext(),
			list:		id_list,
			gallery_page_id: gallery_single.children('.gallery_left').data('gallery_page_id'),
			lightbox:	'fullscreen'
		};
		openLightbox(data);
		return false;
	});

	jQuery('.gallery_close').live('click', function(){
		jQuery('.gallery_single').html('');
		jQuery('.gallery_single').hide();
		return false;
	});

	// for close contact page
	jQuery(".close1").click(
		function(){
			jQuery(this).toggleClass("active").next().slideToggle("normal");
			return false;
		}
	);
	if (jQuery('.contact_adress article').length) {
		jQuery('.contact_adress article').show();
	}

	jQuery(".close2").click(function(){
		jQuery(this).toggleClass("active").next().slideToggle("normal");
		return false;
	});
	if (jQuery('.contact_form article').length) {
		jQuery('.contact_form article').show();
	}

	// Zoom	large image
	zoomLargeImage(jQuery('.lightbox'));
	
	jQuery('.postformat_maximage').each(function(){maxImageInit(jQuery(this))});
//	maxImageInit(jQuery('.postformat_maximage'));
	
	initFancybox();
	
	//custom color inside post
	customPostColor(jQuery('article'));
});



var galleryIterator = {
	list:{},
	prev:'',
	curr:'',
	next:'',
	first_id:'',
	last_id:'',
	curr_found: false,
	get_next: false,
	init: function(id, list) {
		this.reset();
		this.setId(id);
		this.setList(list);
		this.recalculate();
		return true;
	},
	getNext: function() {
		return parseInt(this.next);
	},

	getPrev: function() {
		return parseInt(this.prev);
	},
	getCurr: function() {
		return parseInt(this.curr);
	},
	setId: function(id) {
		this.curr = id;
	},
	setList: function(myList){
		if(typeof myList == 'string')
		{
			if(myList.length)
			{
				var id;
				var arr = myList.split(',');
				for(id in arr)
				{
					this.list.push(arr[id]);
//					this.list[arr[id]] = arr[id];
				}
			}
		}
		else if(typeof myList == 'object')
		{
			this.list = myList;
		}
	},
	recalculate: function() {
		var id, i=0;
		var list = this.list;
		var length = list.length;
//		for (id in this.list) {
		for(i; i < length; i++) {
			
			id = list[i];
			
			if(this.get_next) {
				this.next = id;
				this.get_next = false;
			}

			if(id == this.curr) {
				this.curr_found = true;
				this.get_next = true;
			}
			else {
				if(!this.curr_found){
					this.prev = id;
				}
			}

			if(!this.first_id) {
				this.first_id = id;
			}
			this.last_id = id;
		}

		if(!this.prev) {
			this.prev = this.last_id;
		}

		if(!this.next) {
			this.next = this.first_id;
		}
	},
	reset:function(){
		this.list = {};
		this.prev = '';
		this.curr = '';
		this.next = '';
		this.first_id = '';
		this.last_id = '';
		this.curr_found = false;
		this.get_next = false;
	}
};


var openLightbox = function(gallery_data) {
	switch(gallery_data.lightbox) {
		case 'fullscreen':
			gallery_data['action'] = 'show_gallery_fullscreen_lightbox';
			break;
		case 'small':
			gallery_data['action'] = 'show_gallery_small_lightbox';
			break;
		default:
			gallery_data['action'] = 'show_gallery_fullscreen_lightbox';
			break;
	}

	gallery_data['nonce'] = theme.nonce;

	jQuery.ajax({
		type:		'POST',
		url:		theme.ajaxurl,
		data:		gallery_data,
		dataType:	'json',
		beforeSend: function() {
			
			jQuery('<div class="fancybox-overlay fancybox-overlay-fixed"></div>').appendTo( 'body' ).show();
			jQuery('<div id="fancybox-loading" class="loading"><ul class="load"><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li></ul><div>').appendTo('body');
			showGallery('', gallery_data);
		},
		success:function(response) {
			if(response && response != 0) {
				gallery_lightbox_storage[gallery_data.current] = response;
			}
			showGallery(response, gallery_data);
		}
	});
}

var getID = function(obj) {
	var regex = /post-(\d+)/;
	var match = jQuery(obj).attr('id').match(regex);
	if(match && (typeof match[1] != 'undefined')) {
		return  parseInt(match[1]);
	}
	return false;
}

var showGallery = function(html, gallery_data) {
	var gallery;
	switch(gallery_data.lightbox) {
		case 'small':
			gallery = jQuery('.gallery_small_lightbox');
			break;
		case 'fullscreen':
			gallery = jQuery('.gallery_single');
			break;
		default:
			gallery = jQuery('.gallery_single');
			break;
	}
	if(gallery && gallery.length) {
		if(html == '' && gallery_data.lightbox == 'small'){
			var w = 157, 
				h = 43;
			jQuery('.fancybox-overlay').append(
				jQuery('<div>', {
					'id': 'preloaderbg',
					'style': "width:" + w + "px; height:" + h + "px;background:white;position:absolute; margin-left:0;", 
					'html': '<div id="preloader_progress"></div>'
				}).offset({'left': (jQuery(window).width()-w)/2 + 8, 'top': (jQuery(window).height()-h)/2})
			);
			loadingMove();
		}
		if(html && html.length && html != 0) {
			jQuery.ajaxSetup({async: false});
			jQuery('[data-script]', jQuery(html)).each(function(){
					var list = jQuery(this).data('script').split(',');
					for(var i in list) {
						if(typeof list[i] != 'undefined') {
							themeScripts.load(jQuery.trim(list[i]));
						}
					}
				});
			jQuery.ajaxSetup({async: true});
				
			gallery.html(html);
			gallery.data('current', gallery_data.current);
			gallery.data('list', gallery_data.list);
			gallery.show();
			
//			uglehuck
			if(gallery_data.lightbox == 'small') {
				showLightBoxImagesSmall();
			} else {
				jQuery('.fancybox-overlay, #fancybox-loading').remove();
				showLightBoxImages();
			}
		}
	}
}

var maxImageInit = function(maximg) {
	var gallery = maximg.parent('.postformat_gallery');

	if(typeof gallery != 'undefined' && gallery && gallery.length)
	{
		var article_width = maximg.closest('article').width();
		var first_img = jQuery('img:first', maximg);
		// set gallery height by first image height
		var first_image_width = first_img.prop('naturalWidth');
		var backSize;
		
		if(article_width/first_image_width < 1) 
		{
			gallery.css({height : first_img.prop('naturalHeight') * (article_width/first_image_width) + 'px'});
			backSize = 'cover';
		}
		else
		{
			gallery.css({height : first_img.prop('naturalHeight') + 'px'});
			backSize = 'contain';
		}
		
		var post_id = jQuery(maximg).data('id');
		maximg.maximage({
			cycleOptions: {
				fx: 'fade',
				speed: 1000, 
				timeout: 6000,
				prev: '#prev_'+post_id,
				next: '#next_'+post_id,
				pause: 1
			},
			fillElement: '#postformat_gallery_'+post_id,
			backgroundSize: backSize
		});
		
		jQuery('div.mc-image',maximg ).css('background-size', backSize);
		
		
		return false;
	}
}

var zoomLargeImage = function($lightbox) {
	// Zoom	large image 2
	$lightbox.prepend("<span class='zoom' />");
	$lightbox.hover(
		function(){
			jQuery(this).find("span.zoom").stop().animate({opacity:0},0)
			var sh = jQuery(this).find("img").innerHeight()+2;
			var sw = jQuery(this).find("img").innerWidth()+2;
			if (sh > sw) {
				var hw = sw/2;
			} else {
				var hw = sh/2;
			}
			jQuery(this).find("span.zoom").height('0').width('0').css({'top':sh/2,'left':sw/2,'borderRadius':'100%'}).stop().animate({opacity:1,height:hw,width:hw,top:(sh/2 - hw/2),left:(sw/2 - hw/2)},300);
		},
		function(){
			jQuery(this).find("span.zoom").stop().animate({opacity:0},300);
		}
	);
	
	$lightbox.find('img.alignnone').closest('.lightbox').addClass('alignnone');
	jQuery('.alignnone', $lightbox).find('img').removeClass('alignnone');

	$lightbox.find('img.alignleft').closest('.lightbox').addClass('alignleft');
	jQuery('.alignleft', $lightbox).find('img').removeClass('alignleft');

	$lightbox.find('img.alignright').closest('.lightbox').addClass('alignright');
	jQuery('.alignright', $lightbox).find('img').removeClass('alignright');
	
	/*jQuery("span", $lightbox).css({"opacity": 0});
	$lightbox.hover(function(){
		jQuery(this).children('span').stop().animate({"opacity": 1}, 700);
	},function(){
		jQuery(this).children('span').stop().animate({"opacity": 0}, 500);
	});*/
}

var customPostColor = function($article) {
	jQuery($article).each(function(){
		if (jQuery(this).data('color')){
			var color = jQuery(this).data('color');
			jQuery(this).find('.entry-content a:not(".ui-tabs-anchor"), .comment-entry a').css({'color':color});
			jQuery(this).find('.entry-content a:not(".ui-tabs-anchor"), .comment-entry a').on({
				mouseenter:function(){					
					jQuery(this).css({'color':''});
				},
				mouseleave:function(){
					jQuery(this).css({'color':color});
				}
			});
			
			jQuery(this).find('.qd_list li a').on({
				mouseenter:function(){					
					jQuery(this).css({'color':color});
				},
				mouseleave:function(){
					jQuery(this).css({'color':color});
				}
			});
			
			jQuery(this).find('.zoom, .t_ico').css({'background-color':color});	
			jQuery(this).find('li').on({
				mouseenter:function(){					
					jQuery(this).find('.mark').css({'background-color':color});
				},
				mouseleave:function(){
					jQuery(this).find('.mark').css({'background-color':''});
				}
			});
			jQuery(this).find('.jp-play, .jp-pause, .jp-stop, .jp-video-play-icon, .qd_contact-submit .liquidfolio_button, #commentform #submit, a.qd_button_small, .password_submit').on({
				mouseenter:function(){					
					jQuery(this).css({'background-color':color});
				},
				mouseleave:function(){
					jQuery(this).css({'background-color':''});
				}
			});
			jQuery(this).find('.jp-pause').css({'background-color':color});
			
			
			// only for next prev link
			if(!color || color == '#')
			{
				color = jQuery(this).css('border-color');
			}
			jQuery(this).find('.blog_link a, .prev_post_link a, .next_post_link a').on({
				mouseenter:function(){					
					jQuery(this).css({'background-color':color});
				},
				mouseleave:function(){
					jQuery(this).css({'background-color':''});
				}
			});
		}
	});
}

function initFancybox(content) {
	
	if(typeof content == 'undefined') {
		content = document;
	}

	if(typeof jQuery.fancybox == 'undefined' 
			&& (jQuery("a[data-pp^='lightbox']", jQuery(content)).length > 0 
				||  jQuery('.fancybox', jQuery(content)).length > 0))
	{
		themeScripts.load('fancybox');
	}
	
	if(typeof jQuery.fancybox == 'function')
	{
		// Fancybox for autolinked images
		jQuery("a[data-pp^='lightbox']", jQuery(content)).fancybox({
			fixed: false,
			overlayShow:false,
			afterShow  : function() {
				jQuery('.fancybox-title .child').css({'border-color':jQuery(this.element).data('fancybox-color')});
			}
		});

		//Fancybox for gallery
		jQuery('.fancybox', jQuery(content)).fancybox({
			width     : 757,
			maxWidth  : 757,
			fixed: false,
			overlayShow:false,
			afterShow: function (){
				jQuery('#preloaderbg').remove();
				jQuery('.fancybox-title .child').css({'border-color':jQuery('.gallery_small_lightbox a:first').data('fancybox-color')});
			}
		});

		jQuery(window).resize(function(){
				jQuery.fancybox.update();
		});
	}
	
	jQuery('.lightbox').each(function(){
		jQuery('.zoom', jQuery(this)).css('background-color', jQuery(this).data('color'));
	});
}

function showLightBoxImagesSmall() {
	if(typeof jQuery.fancybox == 'undefined') {
		initFancybox();
	}
	jQuery('.gallery_small_lightbox a:first').trigger('click');
}
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file lightbox.js'); }

// file lightbox.js end

// file lisotop.js start

try { 
jQuery(window).load(function() {
	var elements = jQuery('article a.double_thumb.loading');

	elements.each(function(index){
		var thumb_data ={};
		var $this = jQuery(this);
		thumb_data['gallery_id'] = $this.data('galleryid');
		thumb_data['page_height'] = $this.data('pageh');
		thumb_data['page_width'] = $this.data('pagew');
		thumb_data['gallery_page_id'] = $this.data('gallery_page_id');

		thumb_data['action'] = 'double_gallery_thumbnail';
		$this.css({'background':'transparent'});
		jQuery.ajax({
			type:		'POST',
			url:		theme.ajaxurl,
			data:		thumb_data,
			dataType:	'json',
			beforeSend:function(){
				setTimeout(function() {
					$this.css({'background':''});
					$this.find('ul').addClass('load');
				},index*200);

			},
			success:function(response)
			{
				if (response == ''){
					$this.find('ul').remove().parent().removeClass('loading');
				} else {
					jQuery(response)
						.load(function(){
							jQuery(this).animate({opacity:1}, 500, "easeOutSine");
							$this.find('ul').remove().parent().removeClass('loading');
							addMouseover();
							feelImage($this.parent());
						})
						.appendTo($this);
				}
			}
		});
	});

	isotopeit = jQuery('.gallery_wrap');
	if (isotopeit.length) {

		var original_width	= isotopeit.width();
		jQuery(".gallery_listing").each(function(indexInArray, valueOfElement) {
			var w = parseInt(jQuery(this).css('width'));
			var h = parseInt(jQuery(this).css('height'));
			original_sizes[indexInArray] = {width:w, height:h};
		});

		var verticalScrollBeforInit = hasVerticalScroll();

		var resizeData = resizeGallery(isotopeit, 'init');

		isotopeit.each(function(){
			jQuery(this).isotope({
				masonry: {
					columnWidth: resizeData.new_col_width + resizeData.rest
				},
				itemPositionDataEnabled: true,
				resizable: false,
				onLayout: function( $elems, instance ) {
					isostart = 1;
					var filters = jQuery('.filters a.selected');
					
					if(filters && filters.length)
					{
						if(filters.closest("li").hasClass("*")) {
							resizeGallery(isotopeit, 'onLayout');
						}
					}
					else
					{
						resizeGallery(isotopeit, 'onLayout');
					}
					feelGalleryImages();
				}
			}, function(){
				if(verticalScrollBeforInit != hasVerticalScroll())
				{
					jQuery(window).trigger("resize");
				}
//				fixCSSNoProportionalImages();
			});

			jQuery(this).isotope('reLayout');
		});

		jQuery(window).smartresize(function(){
			if(!isFullscreenSliderShown()) {
				var verticalScrollBeforResize = hasVerticalScroll();
				//			var gallery_wrap_wigth = getGalleryWidth();
				var gallery_wrap_wigth = jQuery('.content_area').width();

				if(original_width != gallery_wrap_wigth)
				{
					// if big resize then big timeout :)
					var diff = Math.abs(gallery_wrap_wigth - original_width);

					var timeout = parseInt(diff / 1.2);

					setTimeout(function(){
							var resizeData = resizeGallery(isotopeit, 'resize');

							isotopeit.isotope({
								// update columnWidth to a percentage of container width
								masonry: {
									columnWidth: resizeData.new_col_width + resizeData.rest
								},
								itemPositionDataEnabled: true
							}, function(){
								sidebarResize();
								if(hasVerticalScroll() != verticalScrollBeforResize)
								{
									jQuery(window).trigger("resize");
								}
							});

							// Save current width size
							original_width = gallery_wrap_wigth;
						},
						100
					);
				}
			}
			

		});
	}

	jQuery('.filters a').click(function(){
		jQuery(this).closest("li").removeClass("cat-item");

		if (jQuery(this).closest("li").hasClass("*")) {
			var selector = "*";
		} else {
			var selector = "." + jQuery(this).closest("li").attr("class");
		}
		isotopeit.isotope({ filter: selector }, function(){
			setGalleryItemsPosition();
		});
		return false;
	});
});

jQuery(function(){

});

var isostart = null
	isMouseOverEvents = false;


function addMouseover(){
	if(isMouseOverEvents) return;
	jQuery(".gallery_listing").on({
		mouseenter:function(){
			if (isostart) {
				var position = jQuery(this).data('isotope-item-position');
				if (position.x == 0) {
					jQuery(this).find('.postcontent').css({"left":parseInt(jQuery(this).data('width')*0.06)+"px","width":"90%"});
				}
				jQuery('img.custom_black_white_thumbnail').stop().css({opacity: "1"});
				jQuery(".gallery_listing img.custom_colored_thumbnail").not(jQuery(this).find('img.custom_colored_thumbnail')).stop().css({opacity: "0"});
				jQuery(this).css({
					"z-index":"9",
					"overflow":""
				}).stop().animate({
						left: "-="+parseInt(jQuery(this).data('width')*0.06),
						top: "-="+parseInt(jQuery(this).data('height')*0.06),
						width: "+="+parseInt(jQuery(this).data('width')*0.12),
						height: "+="+parseInt(jQuery(this).data('height')*0.12)
					}, 200, "easeOutSine");
				if(jQuery(this).data('show_title'))
					jQuery(this).find('.postcontent').css({display:"block"}).find('.postcontent-bg').stop().animate({width: "100%",opacity: 1}, 300, "easeOutSine",function(){jQuery(this).closest('.postcontent').find('.postcontent-indent').animate({opacity:1},200,"linear")});
			}
		},
		mouseleave:function() {
			if (isostart) {
//						console.info('lea ', jQuery(this).data('left'), ' ',jQuery(this).data('top'), ' ', jQuery(this).data('width'), ' ', jQuery(this).data('height'));
				jQuery(this).find('.postcontent').css({display:"none"}).find('.postcontent-bg').stop().animate({width: "60%",opacity: 0}, 50, "easeOutSine");
				jQuery(".gallery_listing img.custom_colored_thumbnail").not(jQuery(this).find('img.custom_colored_thumbnail')).stop().css({opacity: "1"});
				jQuery(this).css({
					"z-index":"1"
				})
					.stop()
					.animate({
						left:	parseInt(jQuery(this).data('left')) > 0 ? jQuery(this).data('left') : '0px',
						top:	parseInt(jQuery(this).data('top')) > 0 ? jQuery(this).data('top') : '0px',
						width:	jQuery(this).data('width'),
						height:	jQuery(this).data('height')
					}, 200, "easeOutSine");
				jQuery(this).find('.postcontent').css({"left":"","width":""}).find('.postcontent-indent').css({"opacity":"0"});
			}
		},
		touchstart:function(){

		},
		touchend:function(){

		}
	});
	isMouseOverEvents = true;
}


function resizeGallery(isoContainer, place)
{
	++onLayoutCount;
	if((!jQuery.browser.msie && (onLayoutCount == 2 || onLayoutCount == 3))
		|| (jQuery.browser.msie && (onLayoutCount == 2))
		)
	{
		return false;
	}

	var rest				= 0;
	var should_be_reduced	= false;
	var new_col_width		= 0;
	var gallery_wrap_wigth	= getGalleryWidth();
//	var gallery_wrap_wigth	= isoContainer.width();


	// if small width
	if(col_width * 2 > gallery_wrap_wigth)
	{
		new_col_width		= parseInt(col_width/2);
		should_be_reduced	= true;
	}
	else
	{
		new_col_width = col_width;
	}
	if(gallery_wrap_wigth)
	{
		var column_count	= parseInt(gallery_wrap_wigth / new_col_width, 10);
		var empty_space		= gallery_wrap_wigth % new_col_width;
		rest				= parseInt(empty_space/column_count);

		if(typeof original_sizes != 'undefined')
		{
			jQuery(".gallery_listing").each(function(indexInArray, valueOfElement) {
				if(typeof original_sizes[indexInArray]['width'] != 'undefined' && typeof original_sizes[indexInArray]['height'] != 'undefined')
				{
					var w = original_sizes[indexInArray]['width'];
					var h = original_sizes[indexInArray]['height'];

					if(should_be_reduced)
					{
						w = parseInt(w/2);
						h = parseInt(h/2);
					}
					jQuery(this).css('width', w + parseInt( rest * jQuery(this).data('wm') ) + 'px');
					jQuery(this).css('height', h + parseInt( rest * jQuery(this).data('hm') ) + 'px');
					
				}
			});
			setGalleryItemsPosition();
			beforOnLayoutWidth = isoContainer.width();
		}
	}
	return {new_col_width:new_col_width , rest:rest};
}

function getGalleryWidth() {
	var content_area_width = jQuery('body').width();
	// data from @media. see js/media.queires.css
	var gallery_wrap_wigth;
	if(0<content_area_width && content_area_width < 478)
	{
		gallery_wrap_wigth = 310;
	}
	else if(479 <content_area_width && content_area_width < 551)
	{
		gallery_wrap_wigth = 460;
	}
	else
	{
//		gallery_wrap_wigth = jQuery('.content_area').width();
		gallery_wrap_wigth = isotopeit.width();

	}
	return gallery_wrap_wigth;
}

function setGalleryItemsPosition()
{
	jQuery(".gallery_listing").each(function(indexInArray, valueOfElement) {
		jQuery(this)
			.data( 'width',		jQuery(this).width() )
			.data( 'height',	jQuery(this).height() )
			.data( 'top',		jQuery(this).css("top") )
			.data( 'left',		jQuery(this).css("left") );

	});
}

function feelGalleryImages()
{
		jQuery(".gallery_listing").each(function(indexInArray, valueOfElement) {
			var $article = jQuery(this);
			feelImage($article);
		});
}

function feelImage($article)
{
	var wm = $article.data('wm'),
	hm = $article.data('hm');

	if( wm == hm)
	{
		var aw = $article.width();
		var ah = $article.height();

		if(aw != ah)
		{
			var imgs = $article.find('a:first img');
			if(imgs && imgs.length)
			{
				imgs.each(function(){
					var img = jQuery(this);
					if(img.css('max-width') != 'none')
					{
						if(img.height() < ah)
						{
							img.css('max-width','none').css('max-height','100%');
						}
					}
					else
					{
						if(img.width() < aw)
						{
							img.css('max-width','100%').css('max-height','none');
						}
					}
				});
			}
		}
	}
}




} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file lisotop.js'); }

// file lisotop.js end

// file script.js start

try { 
/* bgposition for animate loader */
(function(c){function f(a){a=a.replace(/left|top/g,"0px");a=a.replace(/right|bottom/g,"100%");a=a.replace(/([0-9\.]+)(\s|\)|$)/g,"$1px$2");a=a.match(/(-?[0-9\.]+)(px|\%|em|pt)\s(-?[0-9\.]+)(px|\%|em|pt)/);return[parseFloat(a[1],10),a[2],parseFloat(a[3],10),a[4]]}if(!document.defaultView||!document.defaultView.getComputedStyle){var d=jQuery.css;jQuery.css=function(a,b,c){"background-position"===b&&(b="backgroundPosition");if("backgroundPosition"!==b||!a.currentStyle||a.currentStyle[b])return d.apply(this,
arguments);var e=a.style;return!c&&e&&e[b]?e[b]:d(a,"backgroundPositionX",c)+" "+d(a,"backgroundPositionY",c)}}var g=c.fn.animate;c.fn.animate=function(a){"background-position"in a&&(a.backgroundPosition=a["background-position"],delete a["background-position"]);"backgroundPosition"in a&&(a.backgroundPosition="("+a.backgroundPosition+")");return g.apply(this,arguments)};c.fx.step.backgroundPosition=function(a){if(!a.bgPosReady){var b=c.css(a.elem,"backgroundPosition");b||(b="0px 0px");b=f(b);a.start=
[b[0],b[2]];b=f(a.end);a.end=[b[0],b[2]];a.unit=[b[1],b[3]];a.bgPosReady=!0}b=[];b[0]=(a.end[0]-a.start[0])*a.pos+a.start[0]+a.unit[0];b[1]=(a.end[1]-a.start[1])*a.pos+a.start[1]+a.unit[1];a.elem.style.backgroundPosition=b[0]+" "+b[1]}})(jQuery);

var onLayoutCount= 0;
var isotope_blog = null;
// temporary storage for ajax requests
var gallery_lightbox_storage = {};
var original_sizes		= {};
var isotopeit;

var themeScripts = {
	debug		: true,
	inited		: false,
	scriptList	: {},
	isScriptLoaded : function(handle) {
		
		if(typeof this.scriptList[handle] != 'undefined')
		{
			var s = this.scriptList[handle];
			return s.loaded;
		}
		
		return false;
	},
	
	isScriptExistInDOM:function(src) {
		return jQuery('script[src="'+src+'"]').length > 0;
	},
	
	setAsLoaded : function (handle) {
		var s = this.scriptList[handle];
		s.loaded = true;
	},
	
	load: function(handle) {
		if(!this.isScriptLoaded(handle))
		{
			var t = this; // themeScripts object
			t.log('load: TRY load' ,  handle);
			var s =  this.scriptList[handle];
			var scr = s.src;
			
			jQuery.ajaxSetup({async: false});
			jQuery.getScript(scr, function() {
					t.setAsLoaded(handle);
//					t.log('load:', 'loaded ' + handle);
				});
			jQuery.ajaxSetup({async: true});
		}
	},
	
	init : function(theme_scripts) {
		var obj, handle, src;
		var i=0;
		for(i; i<=theme_scripts.length; i++)
		{
			obj = theme_scripts[i];
			for(handle in obj) {
				script_src = obj[handle];
				this.scriptList[handle] = {
					src : script_src,
					loaded: this.isScriptExistInDOM(script_src)
				}
//				this.log('init', handle);
			}
		}
	},
	log : function(func, msg) {
		if(this.debug == true) {
//			console.info(func, ': ',  msg);
		}
	}
};
/*	Retina
 *******************************/
// Set pixelRatio to 1 if the browser doesn't offer it up.
var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
jQuery(window).on("load", function() {
	if (pixelRatio > 1) {
		jQuery('img.retina').each(function(){
			var file_ext = jQuery(this).attr('src').split('.').pop();
			jQuery(this)
				.width(jQuery(this).width())
				.height(jQuery(this).height())
				.attr('src',jQuery(this).attr('src').replace("."+file_ext,"_2x."+file_ext));
		});
		if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
			jQuery('img[data-retina^="http"]').each(function(){
				if(jQuery(this).data('retina') !='')
				{
					jQuery(this).css({"max-height":jQuery(this).height(),"max-width":jQuery(this).width()});
					jQuery(this).attr('src', jQuery(this).data('retina'));
				}
			});
		}
	}
	jQuery(window).resize().scroll();
});



jQuery(function() {
	themeScripts.init(qd_scriptData);
	infiniteScrollInit();
	


	// Sf-menu
	jQuery('.widget_nav_menu ul.menu').addClass(' sf-menu');
	jQuery('ul.sf-menu').superfish({
		hoverClass:  'sfHover',
		delay:       'false',
		animation:   {
			opacity:'show',
			height:'auto'
		},
		speed:       'normal',
		autoArrows:  false,
		dropShadows: false,
		disableHI:   true
	}).supposition();

	jQuery('.main_menu_select select').change(function() {
		window.location = jQuery(this).find("option:selected").val();
	});
	jQuery('ul.sf-menu li:not(".dropdown") > a').on('touchend', function(event){
		var el = jQuery(this);
		var link = el.attr('href');
		window.location = link;
	});

	// Social icon  background  hovers
	jQuery('.entry-content .social_links, .textwidget .social_links, .widget_social_links a').wrapInner('<span />');
	jQuery('.entry-content .social_links span, .textwidget .social_links span, .widget_social_links span').css('opacity', 0);

	jQuery('.entry-content .social_links, .textwidget .social_links, .widget_social_links a').on(
	{
		mouseenter: function() 
		{
			jQuery(this).find('span').stop().fadeTo(200, 1);
		},
		mouseleave: function()
		{
			jQuery(this).find('span').stop().fadeTo(600, 0);
		}
	});



	// Add marker for widget list 
	if (jQuery('.sidebar').data('walign') == 'center' || jQuery('.sidebar').data('walign') == 'right') {
		jQuery('ul.qd_list li').prepend('<span class="mark" />');
	} else {
		jQuery('.widget_links a, .widget_categories a, .widget_meta a, .widget_archive a, .widget_pages a, ul.qd_list li').prepend('<span class="mark" />');
		jQuery('.widget_categories li, .widget_archive li, .widget_pages li, .widget_links li, .widget_meta li').css({'padding-left':'20px'});
		
	}
	if (jQuery('.sidebar').data('walign') == 'center' ) {
		jQuery('.widget_recent_comments li').css({'padding-top':'22px'});
	}
	

	/*jQuery('a').find('img.aligncenter').closest('a').addClass('aligncenter');*/
	jQuery('p').find('img.aligncenter').closest('p').addClass('aligncenter');
	jQuery('p.aligncenter').find('.aligncenter').removeClass('aligncenter');

	// Gallery caption
	jQuery(".gallery-caption").css({"opacity": 0});
	jQuery(".gallery-caption").css({"top": "80%"});
	jQuery(".gallery-item").hover(function(){
		jQuery(this).find('.gallery-caption').stop().animate({"opacity": 1, "top": "100%" }, 500);
	},function(){
		jQuery(this).find('.gallery-caption').stop().animate({"opacity": 0, "top": "80%"}, 200);
	});

	// Widget Images opacity
	jQuery(".widget_gallery img").css({"opacity": 1});
	jQuery(".widget_gallery img").hover(function(){
		jQuery(this).stop().animate({"opacity": 0.8}, 80);
	},function(){
		jQuery(this).stop().animate({"opacity": 1}, 900);
	});

	jQuery(".widget_flickr img").css({"opacity": 1});
	jQuery(".widget_flickr img").hover(function(){
		jQuery(this).stop().animate({"opacity": 0.7}, 80);
	},function(){
		jQuery(this).stop().animate({"opacity": 1}, 900);
	});


	// Widget tag cloud color
	jQuery('.tagcloud a').wrapInner('<span />');
	jQuery('.tagcloud a').prepend('<b />');
	jQuery('.tagcloud a').each(function(){
		jQuery('b', jQuery(this)).css('background-color', jQuery(this).data('color'));
	});
	
	//Zoom color
	jQuery('.lightbox').each(function(){
		jQuery('.zoom', jQuery(this)).css('background-color', jQuery(this).data('color'));
	});
	
	jQuery('#copyright .menu li:last-child').addClass('last');
	jQuery('.twitter-item').prepend('<span class="twitter-icon"></span>');
	jQuery('blockquote').find('cite').closest('blockquote').addClass('cite');

	// Toggles and Tabs
	jQuery(".toggle_container").hide();
	jQuery("h4.trigger").live('click', function(){
		jQuery(this).toggleClass("active").next().slideToggle("normal");
		return false;
	});
	
	initTabGroup();

	// Filters
	jQuery('.filters').find('ul a').click(function(){
		if ( !jQuery(this).hasClass('selected') ) {
			jQuery(this).parents('ul').find('.selected').removeClass('selected').css('border-bottom-color', 'transparent');
			jQuery(this).addClass('selected').css('border-bottom-color', jQuery(this).data('color'));
		}
	});
	// Filters
	jQuery('.filters a.selected').css('border-bottom-color', function(){ return jQuery(this).data('color');});
	jQuery('.filters a').on({
		mouseenter:function(){
			jQuery(this).css('border-bottom-color', jQuery(this).data('color'));
		},
		mouseleave:function(){
			jQuery(this).not('.selected').css('border-bottom-color', 'transparent');
		}
	});


	// Main menu border color	
	jQuery('.main_menu ul li.current-menu-item>a').css('border-color', function(){ return jQuery(this).data('color');});
	jQuery('.main_menu ul li').on({
		mouseenter:function(){
			jQuery(this).find('a:first').css('border-color', jQuery(this).find('a:first').data('color'));
		},
		mouseleave:function(){
			jQuery(this).not('.current-menu-item').find('a:first').css('border-color', 'transparent');
		}
	});


	function matrixToArray(matrix) {
		return matrix.substr(7, matrix.length - 8).split(', ');
	}

	// Post color
	/*jQuery('article.post a, article #submit').on({
		mouseenter:function(){
			var post_color = jQuery(this).closest('article').attr('data-color');
			jQuery(this).filter(".qd_button_small, #submit").css('background',post_color);
		},
		mouseleave:function() {
			jQuery(this).filter(".qd_button_small, #submit").css('background','');
		}
	});*/

	if (jQuery("#commentform").length) {
		jQuery("#commentform").validate({
			submitHandler: function(form) {
				jQuery(".comment-form-submit input[type='submit']").attr('disabled', 'disabled');
				this.form.submit();
			},
			rules: {
				email: "required email"
			},
			messages: {
				author: "Please specify your name.",
				comment: "Please enter your message.",
				email: {
					required: "We need your email address to contact you.",
					email: "Your email address must be in the format of name@domain.com"
				}
			}
		});
	}
	
});
// End jQuery(document).ready(function() //

jQuery(window).smartresize(function(){
	blogReLayout();
	locationMapResize();
	sidebarResize();
});

jQuery(window).load(function() {
	//google map resize
	locationMapResize();

	jQuery( document ).on( "mouseenter", ".share_box", function( e ) {
			jQuery(this).sharrre({
				share: {
					twitter: true,
					facebook: true,
					googlePlus: true,
					linkedin: true,
					pinterest: true
				},
				template: '<div class="box"><div class="middle"><a href="#" class="pinterest" title="pinterest">p</a><a href="#" class="linkedin" title="linkedin">in</a><a href="#" class="googleplus" title="googleplus">g</a><a href="#" class="twitter" title="twitter">t</a><a href="#" class="facebook" title="facebook">f</a></div></div>',
				enableHover: false,
				enableTracking: false,
				urlCurl:jQuery(this).data('curl'),
				render: function(api, options){
					jQuery(api.element).on('click', '.twitter', function() {
						api.openPopup('twitter');
						return false;
					});
					jQuery(api.element).on('click', '.facebook', function() {
						api.openPopup('facebook');
						return false;
					});
					jQuery(api.element).on('click', '.googleplus', function() {
						api.openPopup('googlePlus');
						return false;
					});
					jQuery(api.element).on('click', '.linkedin', function() {
						api.openPopup('linkedin');
						return false;
					});
					jQuery(api.element).on('click', '.pinterest', function() {
						api.openPopup('pinterest');
						return false;
					});
				}
			});
//		}

	});



	//viewport scale
	if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) {
		jQuery('.jc-prev, .jc-next').remove();
		var viewportmeta = document.querySelector('meta[name="viewport"]');
		if (viewportmeta) {
			viewportmeta.content = 'width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0';
			document.body.addEventListener('gesturestart', function () {
				viewportmeta.content = 'width=device-width, minimum-scale=0.25, maximum-scale=1.6';
			}, false);
		}
	}

	if(isotope_blog && typeof isotope_blog != 'undefined')
	{
		blogReLayout(sidebarResize);
		jQuery('.content_area .post_wrap').css({'visibility':'visible'});
		blogReLayout(sidebarResize);
		hideBlogPreLoader();
	}
	initFitvids();
});
// End jQuery(window).load(function()

jQuery(document).ready(function(){
	initFitvids();
	isotope_blog = jQuery('body:not(".single") .content_area .post_wrap');
	isotope_blog.isotope({masonry: {columnWidth: 277}, itemSelector: '.posts_listing'});
	
	addBlogPreloader();
});


function hasVerticalScroll(node){
	if(node == undefined){
		if(window.innerHeight){
			return document.body.offsetHeight> innerHeight;
		}
		else return  document.documentElement.scrollHeight >
			document.documentElement.offsetHeight ||
			document.body.scrollHeight>document.body.offsetHeight;
	}
	else return node.scrollHeight> node.offsetHeight;
}

function locationMapResize()
{
	if(jQuery('.location-map-canvas').length)
	{
		jQuery('.location-map-canvas, .location-map-canvas-panel').css('height', '');
		var content_area_width = jQuery('body').width();
		// data from @media. see js/media.queires.css
		var map_height = 900;

		/*if(0<content_area_width && content_area_width < 478)
		{
			map_height = 200;
		}
		else if(479 <content_area_width && content_area_width < 551)
		{
			map_height = 300;
		}
		else
		{*/
			if(jQuery('.content_bg').length && jQuery('.header_bar').length)
			{
				map_height = jQuery(document).outerHeight() - jQuery('.header_bar').outerHeight();
			}
		/*}*/

		jQuery('.location-map-canvas, .location-map-canvas-panel').css('height', map_height + 'px');

	}
}

function sidebarResize()
{
	if(jQuery('.header_bar').length && jQuery('header').length && jQuery('footer').length)
	{
		setTimeout(function() {
			var content_area_width = jQuery('body').width();
			jQuery('#main_sidebar').css('height', '');
			if(content_area_width > 551)
			{
				var sidebar_height = jQuery('.header_bar').outerHeight() + jQuery('header').outerHeight() + jQuery('footer').outerHeight();

				if(sidebar_height < jQuery(document).outerHeight())
				{
					var push_height = jQuery(document).outerHeight()- jQuery('.header_bar').outerHeight() - jQuery('header').outerHeight() - jQuery('#copyright').outerHeight()-6;
					jQuery('#main_sidebar').css('height', push_height + 'px');
				}
			}
		},700);
	}
}

function infiniteScrollInit() {
	
	
	if(jQuery('.content_area #load').length > 0 || (jQuery('a.hidden_link').length > 0 && jQuery('.infinite').length))
	{
		var infinite_scroll = {};
		if(jQuery('.content_area #load').length > 0){
			infinite_scroll = {
				"nextSelector":".pagination ul .next",
				"navSelector":".pagination ul",
				"itemSelector":"article.posts_listing",
				"contentSelector":".infinite",
				"loadingImg":"",
				"loadingText" :"",
				"donetext": ""
			};
		}
		
		var shown		= jQuery('.post_wrap article').length;

		if(typeof scrollData != 'undefined' && typeof scrollData.found_posts != undefined)
		{
			found_posts = parseInt(scrollData.found_posts);
		}
		
		jQuery( infinite_scroll.contentSelector ).infinitescroll( infinite_scroll,	function( newElements ) {
				var timeout = 0;
				jQuery( newElements ).css('visibility','hidden');
				zoomLargeImage(jQuery('.lightbox', newElements));
				customPostColor(newElements);
				
				jQuery.ajaxSetup({async: false});
				jQuery('[data-script]', newElements).each(function(){
					var list = jQuery(this).data('script').split(',');
					for(var i in list) {
						if(typeof list[i] != 'undefined') {
							themeScripts.load(jQuery.trim(list[i]));
						}
					}
				});
				
				jQuery.ajaxSetup({async: true});
				
				contactFormValidation();
				
				initTabGroup(newElements);
				
				initFancybox(newElements);
				
				if (jQuery('.video_frame', newElements).length) {
					jQuery('.video_frame', newElements).fitVids();
				}
				
				jQuery(newElements ).imagesLoaded(function(){
					
					jQuery('.postformat_maximage', newElements).each(function(){maxImageInit(jQuery(this))});
					jQuery( newElements ).css('visibility','visible');
					if(typeof isotope_blog != 'undefined')
					{
						isotope_blog.isotope( 'appended', jQuery( newElements ), isotopeAppended );
					}
				});
			
				initFitvids();

				if(jQuery('blockquote.twitter-tweet', newElements).length > 0) {
					try{
						twttr.widgets.load();
					}catch(e){
						var s = document.createElement('script');
						s.src = '//platform.twitter.com/widgets.js';
						s.onload = function(){
							twttr.widgets.load();
							blogReLayout();
						};
						var x = document.getElementsByTagName('script')[0];
						x.parentNode.insertBefore(s, x);
					}
					timeout = 1200;
				}

				jQuery(newElements).each(function(){
					var article = jQuery(this);
					if(article.hasClass('format-audio')) {
						var id = jQuery('.jp-jplayer', article).data('iterator');
						initAudioTrack(id);
					}

					if(article.hasClass('format-video')) {
						initVideo(article);
					}
				});
				if(typeof isotope_blog != 'undefined')
				{
					// UGLY-MAGIG HACK FOR TWIT RELAYOUT
					setTimeout(blogReLayout, timeout);
				}

				shown += newElements.length;
				
				if(found_posts == shown)
				{
					jQuery('a#load, .pagination_line').remove();
				}
			}
		);
		// kill scroll binding
		jQuery(window).unbind('.infscr');

		// hook up the manual click guy.
		jQuery('a#load, a.hidden_link').click(function(){
			jQuery(infinite_scroll.contentSelector).infinitescroll('retrieve');
			return false;
		});
		
		// remove the paginator when we're done.
		jQuery(document).ajaxError(function(e,xhr,opt){
			if (xhr.status == 404) jQuery('a#load, .pagination_line').remove();
		});
	}
}
		
function isotopeAppended() {
	blogReLayout(sidebarResize);
	initFitvids();
	sidebarResize();
}

/**
 * load missing in DOM scripts (async:false need)
 */
function loadMissingScript($content) {
	jQuery.ajaxSetup({async: false});
	jQuery('[data-script]', $content).each(function(){
		var list = jQuery(this).data('script').split(',');
		for(var i in list) {
			if(typeof list[i] != 'undefined') {
				themeScripts.load(jQuery.trim(list[i]));
			}
		}
	});
	jQuery.ajaxSetup({async: true});
}

/**
 * call method validate with parameters to contact form if exist
 */
function contactFormValidation($content) {
	
	var shortcode_contact_forms = jQuery('form.qd_contact-form' , $content);
	
	if(shortcode_contact_forms && shortcode_contact_forms.length > 0) {
		shortcode_contact_forms.each(function(){
			var $this	= jQuery(this);
			var id		= $this.attr('id');
			
			if(id && id.length) {
				var valObj = {
					submitHandler: function(form) {
							ajaxContact(form);							
							jQuery('div.qd_contact-submit input', $this).attr('disabled', 'disabled');	
							return false;
						}
				};
				
				if(jQuery('input[name="validate_rules"]', $this).length > 0) {
					var rules_messages = JSON.parse(jQuery('input[name="validate_rules"]', $this).val());
					if(typeof rules_messages == 'object')
					{
						valObj = jQuery.extend(valObj, rules_messages || {});
					}
				}
				
				$this.validate(valObj);
			}
		});
	}
}

function initTabGroup(content) {
	if(typeof content == 'undefined')
	{
		content = document;
	}

	if (jQuery('.tabgroup', jQuery(content)).length) {
		jQuery('.tabgroup', jQuery(content)).tabs().show();
	}
}

function is_safari()
{
	return navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1
}

function blogReLayout(callback)
{
	if(isotope_blog && typeof isotope_blog != 'undefined' && isotope_blog.length)
	{
		if(typeof callback == 'function')
		{
			isotope_blog.isotope('reLayout', callback());
		}
		else{
			isotope_blog.isotope('reLayout');
		}
	}
}

function addBlogPreloader()
{
	jQuery('body.blog').prepend('<div id="preloader"><div id="preloaderwrap"><div id="preloaderbg"><div id="preloader_progress"></div></div></div></div>');
	loadingMove();
}

function hideBlogPreLoader()
{
	jQuery('#preloader').fadeOut(1000);
}

function loadingMove(event) {	
	if (!event) {			
		jQuery('#preloader_progress')
				.css({backgroundPosition: '0 0'})
				.animate({backgroundPosition: '100% 0'},  10000);
	} else {
		return false;
	}
}

} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file script.js'); }

// file script.js end

// file video.js start

try { 
jQuery(window).load(function() {
	initFitvids();	
});



var galleryVideo = {
	vimeo: {},
	youtube: {},
	selfhosted:{},
	addVideoID : function(player, id){
		if(player == 'youtube')
		{
			this.youtube[id] = id;
		}
		else if(player == 'vimeo')
		{
			this.vimeo[id] = id;
		}
		else
		{
			this.selfhosted[id] = id;
		}
	},
	addAudio:function(player, id ) {
		this.selfhosted[id] = id;
	},
	pauseOther:function(exceptID)
	{
		this.pauseYouTube(exceptID);
		this.pauseVimeo(exceptID);
		this.pauseSelfhosted(exceptID);
	},
	pauseYouTube: function(exceptID){
		for (id in this.youtube)
		{
			var ytplayer1 = document.getElementById(id);
			if(ytplayer1)
			{
				var ytp1State = ytplayer1.getPlayerState();
				if(ytp1State == 1 && (ytplayer1.id != exceptID))
				{
					ytplayer1.pauseVideo();
				}
			}
		}
	},
	pauseVimeo: function(exceptID){
		for (id in this.vimeo)
		{
			if(id != exceptID )
			{
				var vp = $f(jQuery('#'+id).get(0));
				if(vp)
				{
					vp.api('pause');
				}
			}
		}
	},
	pauseSelfhosted: function(exceptID){
		for (id in this.selfhosted)
		{
			if(id != exceptID )
			{
				jQuery(id).jPlayer("pause"); // pause all players except this one.;
			}
		}
	}
};


function initAudioTrack(iterator/*, media, format*/)
{
	var audio_player = jQuery("#jquery_jplayer_" + iterator);
	var media = audio_player.data('media');
	var format = audio_player.data('format');

	if(audio_player.length)
	{
		galleryVideo.addAudio('jplayer', '#jquery_jplayer_' + iterator);
		jQuery.jPlayer.timeFormat.showHour = true;

		audio_player.jPlayer({
			ready: function(event) {
				jQuery(this).jPlayer("setMedia", media);
				audio_player.bind(jQuery.jPlayer.event.play, function() {
					galleryVideo.pauseOther('#jquery_jplayer_' + iterator);
				});
			},
			play: function() {
				jQuery(this).jPlayer("pauseOthers");
			},
			swfPath: THEME_URI+"/swf",
			solution: "html, flash",
			preload: "metadata",
			wmode: "window",
			supplied : format,
			cssSelectorAncestor: '#jp_container_' + iterator
		});
	}


}

function isFullscreenSliderShown() {
	var slider  = jQuery('.gallery_single');
	if(slider && slider.length) {
		return slider.css('display') != 'none';
	}
	return false;
}

function initVimeoVideo (player_id) {
	var iframe = jQuery('#id' + player_id).get(0);
	var player = Froogaloop(iframe);
	player.addEvent('ready', function() {
		player.addEvent('play', function() {galleryVideo.pauseOther('id' + player_id);});
		player.addEvent('seek', function() {galleryVideo.pauseOther('id' + player_id);});
		blogReLayout();
	});
	galleryVideo.addVideoID('vimeo', 'id' + player_id);
}

function initVideo(article) {

	try{
		if(jQuery('iframe', article).length && jQuery('iframe', article).data('player') == 'vimeo')
		{
			initVimeoVideo(jQuery('iframe', article).data('id'));
		}
		else if(jQuery('.youtube', article).length > 0)
		{
			initYoutube(jQuery('.youtube', article).data('id'), article);
		}
		else // selfhosted
		{
			initSelfhostedVideo(jQuery('.jp-video', article).data('jplayer'));
		}
	}
	catch(e)
	{
		 if (console && console.error)  console.error('error: ' + e + ' in initVideo() function'); 
	}
}

function initYoutube(youtube_id , article) {

	if(youtube_id && !is_safari()) {
		var params = {allowFullScreen: 'true', allowScriptAccess: 'always', wmode: 'opaque'};
		var flashvars = {enablejsapi: '1', playerapiid: 'id' + youtube_id, id: 'id' + youtube_id};
		swfobject.embedSWF("http://www.youtube.com/v/"+youtube_id, "id"+youtube_id, "532", "300", "9.0.0", false, flashvars, params);

		if(typeof article != 'undefined') {

			var script	= document.createElement( 'script' );
			script.type = 'text/javascript';
			script.text = " function pauseOtherExcept_id"+youtube_id+"(state) { if(state == 1) { galleryVideo.pauseOther('id" + youtube_id + "'); } } ";
			article.append( script );
		}
		else
		{
			isotopeAppended();
		}
	}
}

function onYouTubePlayerReady(playerId) {
	//get the the playerapiid of the video that calls this function
	var player = jQuery('#'+playerId)[0];
	//add an event-listener to the player to run when the state changesвЂ¦
	//вЂ¦that passes the player's ID through to the next function
	galleryVideo.addVideoID('youtube', playerId);
	if(player)
	{
		if (player.addEventListener) {
			player.addEventListener('onStateChange','pauseOtherExcept_'+playerId);
		}
		else
		{
			player.attachEvent('onStateChange','pauseOtherExcept_'+playerId);
		}
		blogReLayout();
	}
}

function initSelfhostedVideo(dataObj)
{
	if(typeof dataObj != 'object')
	{
		dataObj  = JSON.parse(dataObj);
	}
	
	if(typeof dataObj == 'object')
	{
		var i = dataObj.iterator;
		var size;
		if(jQuery('.post_single').length){
			size = {'height':'400px', 'width':'100%'};
		}
		else
		{
			size = dataObj.size;
		}
		galleryVideo.addVideoID('jplayer', '#jquery_jplayer_' + i);
		jQuery("#jquery_jplayer_" + i).jPlayer({
			ready: function() {
				jQuery(this).jPlayer("setMedia", dataObj.media);
				jQuery('#jquery_jplayer_' + i).bind(jQuery.jPlayer.event.play, function() { // Bind an event handler to the instance's play event.
					galleryVideo.pauseOther('#jquery_jplayer_' + i);
				});

			},
			swfPath: THEME_URI + "/swf",
			size: size,
			cssSelectorAncestor: "#jp_container_" + i,
			supplied: dataObj.supplied
		});
	}
}

function initFitvids()
{
	if (jQuery('.video_frame').length) {
		jQuery('.video_frame').fitVids();
	}
}
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file video.js'); }

// file video.js end

