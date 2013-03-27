(function() {
    var
        fullScreenApi = {
            supportsFullScreen: false,
            isFullScreen: function() { return false; },
            requestFullScreen: function() {},
            cancelFullScreen: function() {},
            fullScreenEventName: '',
            prefix: ''
        },
        browserPrefixes = 'webkit moz o ms khtml'.split(' ');

    // check for native support
    if (typeof document.cancelFullScreen != 'undefined') {
        fullScreenApi.supportsFullScreen = true;
    } else {
        // check for fullscreen support by vendor prefix
        for (var i = 0, il = browserPrefixes.length; i < il; i++ ) {
            fullScreenApi.prefix = browserPrefixes[i];

            if (typeof document[fullScreenApi.prefix + 'CancelFullScreen' ] != 'undefined' ) {
                fullScreenApi.supportsFullScreen = true;

                break;
            }
        }
    }

    // update methods to do something useful
    if (fullScreenApi.supportsFullScreen) {
        fullScreenApi.fullScreenEventName = fullScreenApi.prefix + 'fullscreenchange';

        fullScreenApi.isFullScreen = function() {
            switch (this.prefix) {
                case '':
                    return document.fullScreen;
                case 'webkit':
                    return document.webkitIsFullScreen;
                default:
                    return document[this.prefix + 'FullScreen'];
            }
        }
        fullScreenApi.requestFullScreen = function(el) {
            return (this.prefix === '') ? el.requestFullScreen() : el[this.prefix + 'RequestFullScreen']();
        }
        fullScreenApi.cancelFullScreen = function(el) {
            return (this.prefix === '') ? document.cancelFullScreen() : document[this.prefix + 'CancelFullScreen']();
        }
    }

    // jQuery plugin
    if (typeof jQuery != 'undefined') {
        jQuery.fn.requestFullScreen = function() {

            return this.each(function() {
                if (fullScreenApi.supportsFullScreen) {
                	if (fullScreenApi.isFullScreen()) {
                		fullScreenApi.cancelFullScreen(this);
                	} else {
                		fullScreenApi.requestFullScreen(this);
                	}
                }
            });
        };
    }

    // export api
    window.fullScreenApi = fullScreenApi;
})();

$(function() {

	var last_url;

	$(document).on('webkitfullscreenchange mozfullscreenchange fullscreenchange', function() {
		if (fullScreenApi.isFullScreen() === false) {
			$('<div/>').attr('id', 'dummy').appendTo('body');
			$.pjax({
				url: last_url,
				container: '#dummy',
				push: true,
				complete: function() {
					$('#dummy').remove();
				}
			});
		}
	});

	function show() {
		$('body').removeClass('loading');
		setContent();

		$('#content').animate({ opacity: 1 }, 400, function() {
			$(this).addClass('animate');
		});
	}

	function bindImg() {

		if (fullScreenApi.supportsFullScreen) {
			$('#lbox-bttn-fs, #lbox-bttn-ns').off('click').bind('click', function() {
				$(document.documentElement).requestFullScreen();
				return false;
			});
		} else {
			$('#lbox-bttn-fs, #lbox-bttn-ns').hide();
		}

		$('#content img').off('load').bind('load', function() {
			show();
		});
	}

	function setUrl() {

		var w = $(window).width(),
			h = $(window).height(),
			containerAspect = w/h,
			imageAspect = window.aspect,
			side, len, url, p;

		if (imageAspect >= containerAspect) {
			side = 'width';
			len = w;
		} else {
			side = 'height';
			len = h;
		}

		if (window.presets) {
			for (var i in window.presets) {
				p = window.presets[i];
				if (p[side] >= len) {
					break;
				}
			}

			if ($('#content img').length) {
				$('#content img').attr({
					src: p.url,
					width: p.width,
					height: p.height
				});
			} else {
				$('<img/>').attr({
					src: p.url,
					width: p.width,
					height: p.height
				}).prependTo('#content');
			}

		} else if (!$('#content video').length) {
			var v = $('<video/>').attr({
				src: window.videoFile,
				preload: 'metadata'
			}).
			css({
				width: '100%',
				height: '100%'
			}).prependTo('#content');

			$('video').mediaelementplayer({
				success: function(player, dom) {
					$(player).bind('loadedmetadata', function() {
						show();
						v.data('aspect', this.videoWidth / this.videoHeight );
						$K.resizeVideos();
					});
				}
			});
		}

		bindImg();
	}

	function setContent() {
		var h = $(window).height() - $('footer').outerHeight(true);

		$('#main').css('height', h);

		if (state.caption) {
			h -= $('div.caption').outerHeight(true);
		}

		var w = $('#main').width(),
			containerAspect = w/h,
			imageAspect = window.aspect,
			_w, _h,
			img = $('#content img');

		if (img) {
			var originalW = img.attr('width'),
				originalH = img.attr('height');

			if (imageAspect >= containerAspect) {
				_w = w;
				_h = Math.round( _w / imageAspect );
			} else {
				_h = h;
				_w = Math.round( _h * imageAspect );
			}

			if (_w > originalW || _h > originalH) {
				_w = originalW;
				_h = originalH;
			}

			$('#content img').attr({
				width: _w,
				height: _h
			});
		}

		if (_h < h) {
			$('#content').css({
				top: (h - _h) / 2 + 'px'
			});
		} else {
			$('#content').css({
				top: 0
			});
		}
	}

	var next = function() {
		if ($('#rnav a').length) {
			$('#rnav a').addClass('hover').trigger('click');
		} else if (state.playing) {
			toggleState('playing');
		}
		return false;
	};

	$(window).bind('resize', function() {
		setUrl();
		setContent();
	});

	var playInterval,
		state = {
			playing: $.cookie('koken_lightbox_play'),
			caption: $.cookie('koken_lightbox_caption')
		},
		go = false;

	function toggleState(name) {
		state[name] = !state[name];
		if (name === 'playing' && state.playing) {
			go = true;
		} else {
			go = false;
		}
		update();
	}

	window.update = function() {
		setUrl();
		setupPrerender();

		var klass, clabel,
			c = $('div.caption');

		if (state.playing && $('#rnav a').length) {
			if ($('#lbox-bttn-play').is(':visible') && !go) {
				clearTimeout(playInterval);
				playInterval = window.setTimeout(next, 5000);
			}
			$('#lbox-bttn-pause').show();
			$('#lbox-bttn-play').hide();
		} else {
			state.playing = false;
			go = false;
			clearTimeout(playInterval);
			$('#lbox-bttn-pause').hide();
			$('#lbox-bttn-play').show();
		}

		if (state.caption) {
			c.fadeIn();
			clabel = 'Hide caption';
		} else {
			c.fadeOut();
			clabel = 'Show caption';
		}
		$('#btn-toggle').text(clabel);

		if (state.playing) {
			$.cookie('koken_lightbox_play', state.playing);
		} else {
			$.removeCookie('koken_lightbox_play');
		}

		if (state.caption) {
			$.cookie('koken_lightbox_caption', state.caption);
		} else {
			$.removeCookie('koken_lightbox_caption');
		}

		setContent();

		if (go) {
			next();
		}
		go = false;
	};

	$(document).on('click', '#lbox-bttn-play, #lbox-bttn-pause', function() {
		toggleState('playing');
		return false;
	});

	$(document).on('click', '#btn-toggle', function() {
		toggleState('caption');
		return false;
	});

	$(document).on('click', '#rnav a, #lnav a', function(event) {
		if (fullScreenApi.isFullScreen()) {
			last_url = $(this).attr('href');
			$(document).trigger('pjax.start');
			$.ajax({
				url: last_url,
				beforeSend: function(xhr, settings) {
					xhr.setRequestHeader('X-PJAX', 'true');
				},
				success: function(data) {
					$('#lbox').html(data);
				}
			});
		} else {
			$.pjax({
				url: $(this).attr('href'),
				container: '#lbox'
			});
		}
		return false;
	});

	$(document).on('click', '#content img, #lbox-bttn-close', function() {

		$.removeCookie('koken_lightbox_play');
		$.removeCookie('koken_lightbox_caption');

		var root = $K.location.root;

		if (!$K.location.referer) {
			$K.location.referer = location.href;
		}

		$K.location.referer = location.href.replace(/^(preview|index)\.php|\/lightbox/, '');

		var template;

		// TODO: Account for slugs, filenames, etc in routes
		if ($K.location.defaults.content) {
			template = '^' + root + $K.location.defaults.content.replace(/\:[a-z_-]+/g, '([^/]+)') + '$';
			if ($K.location.referer.match(RegExp(template))) {
				location.href = root + $K.location.defaults.content.replace(':id', contentId);
				return false;
			}
		}
		if ($K.location.defaults.content_in_album) {
			template = '^' + root + $K.location.defaults.content_in_album.replace(/\:[a-z_-]+/g, '([^/]+)') + '$';
			if ($K.location.referer.match(RegExp(template))) {
				location.href = root + $K.location.defaults.content_in_album.replace(':id', contentId).replace(':album_id', albumId);
				return false;
			}
		}

		if ($K.location.referer.indexOf('http://') === -1 && !$K.location.rewrite) {
			location.href = root + $K.location.referer;
		} else {
			location.href = $K.location.referer;
		}

		return false;
	});

	$(document).on('pjax.start', function() {
		$('body').addClass('loading');
	});

	$(document).keydown(function(e){

		switch(e.keyCode) {
			case 37:
				if ($('#lnav a').length) {
					$('#lnav a').addClass('hover').trigger('click');
					return false;
				}
				break;

			case 39:
				next();
				break;

			case 32:
				toggleState('playing');
				break;

			case 67:
				toggleState('caption');
				break;

			case 70:
				$('#lbox-bttn-fs').trigger('click');
				break;

			case 27:
				$('#lbox-bttn-close').trigger('click');
				break;
		}

	});

	if (!$K.location.referer || $K.location.referer.indexOf('/lightbox') === -1) {
		$.removeCookie('koken_lightbox_play');
		$.removeCookie('koken_lightbox_caption');
	}

	function setupPrerender() {

		$('head').find('link[rel="prerender"]').remove();

		$('#rnav, #lnav').each(function(i, el) {
			var a = $(el).find('a');

			if (a.length) {
				$('<link/>').attr({
					rel: 'prerender',
					href: a.attr('href') + ($.support.pjax ? '?_pjax=true' : '')
				}).appendTo('head');
			}

		});

	}

	update();
});