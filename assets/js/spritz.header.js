var j = jQuery.noConflict();



j(document).ready(function(e) {

			var sPopupWidth  = j(".spritzer_popup").width();

	var sPopupHeight = j(".spritzer_popup").height();

	

			j(".spritzer_popup").css({});	 																			/* Inline Reader */

			j('body').on('click','.spritzinlinewpopup_close,.spritztabwpopup_close,.spritzpopup_backdrop',function(event){

		if(j(event.target).hasClass('spritzinlinewpopup_close') || j(event.target).hasClass('spritztabwpopup_close') || j(event.target).hasClass('spritzpopup_backdrop')){

			if(typeof(j(".spritzer").data("controller")) != 'undefined'){

				var sp = j(".spritzer").data("controller");

				sp.stopSpritzing()

			}

			

			if(j(this).hasClass("spritzpopup_backdrop")){

				j().closes(j(this));

				j().closes(j(".spritzer_popup"));

			}else{

				j().closes(j(".spritzpopup_backdrop"));

				j().closes(j(this).parents(".spritzer_popup"));

			}

		}

	})

	

	j.fn.closes = function(e){

					e.fadeOut(500,function(){j(this).hide()});

	}

	

	j.fn.opens = function(e){

					e.fadeIn(500,function(){j(this).show()});

	}

	

	j('body').on('click','.tabpopup,.inlinepopup',function(event){ /* Other clicked */

		

		var selector = (typeof(j(this).data('selector'))!='undefined') ? j(this).data('selector') : '';

		

		if(selector==''){

			if("p" != ''){

				selector='p';

			}else{

				selector = '';

			}

		}else{

			selector = selector;

		}

		

		var url = (typeof(j(this).data('target')) != 'undefined') ? j(this).data('target') : '';

		var urls="<?php echo SPRITZ__PLUGIN_URL; ?>wp.spritz.content.filter.php?url="+url+"&selector=<?php echo $region; ?>&tages=.yoko-spritz-container";

		

		if(urlfilter(url)){

			if(selector == ''){

				SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError);

			}else{

				SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError,selector);

			}

		}else{

			var urls="<?php echo SPRITZ__PLUGIN_URL; ?>wp.spritz.content.filter.php?url="+document.URL+"&selector=<?php echo $region; ?>&tages=.yoko-spritz-container";

			

			if(selector == ''){

				SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError);

			}else{

				SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError,selector);

			}

		}

		

		j().opens(j(".spritzer_popup,.spritzpopup_backdrop"));

		j().whenResize();

	})

	

	/* Inline Reader */

	j('body').on('click','.inlinereader',function(event){ /* remove .inlinereader */

		if(j(this).hasClass('activeReader')){

			var sp = j(this).prev(".spritzer_popup").find(".spritzer");

			

			if(typeof(sp.data("controller")) != 'undefined'){

				sp.data("controller").stopSpritzing();

			}

			

			j(this).prev(".spritzer_popup").slideUp();

			j(this).removeClass('activeReader');

			j(this).prev(".spritzer_popup").removeClass('activeReader');

		}else{

			j(this).addClass('activeReader');

			j(this).prev(".spritzer_popup").addClass('activeReader lastClick');

			j(this).prev(".spritzer_popup").slideDown();

		

			var selector = (typeof(j(this).data('selector'))!='undefined') ? j(this).data('selector') : '';

			

			if(selector == ''){

				if("p" != ''){

					selector='p';

				}else{

					selector='';

				}

			}else{

				selector=selector;

			}

			

			selector = getSelector(selector);

			var url = (typeof(j(this).data('target')) != 'undefined') ? j(this).data('target') : '';

			var urls="<?php echo SPRITZ__PLUGIN_URL; ?>wp.spritz.content.filter.php?url="+urls+"&selector=<?php echo $region; ?>&tages=.yoko-spritz-container";

			

			if(urlfilter(url)){

				if(selector == ''){

					SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError);

				}else{

					SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError,selector);

				}

			}else{

				var urls="<?php echo SPRITZ__PLUGIN_URL; ?>wp.spritz.content.filter.php?url="+document.URL+"&selector=<?php echo $region; ?>&tages=.yoko-spritz-container";

				

				if(selector == ''){

					SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError);

				}else{

					SpritzClient.fetchContents(urls, onSpritzifySuccess, onSpritzifyError,selector);

				}

			}

		}

	})



	j('body').on('click','.spritzinlinereader_close',function(event){

		var realObj = j(this).parents(".spritzer_popup");

		

		if(realObj.hasClass('activeReader')){

			var sp = realObj.find(".spritzer");

			

			if(typeof(sp.data("controller")) != 'undefined'){

				sp.data("controller").stopSpritzing();

			}

		}

		

		if(realObj.hasClass('activeReader')){

			realObj.removeClass('activeReader');

		}

		

		realObj.parent().find('a.spritz_start').removeClass('activeReader');

		realObj.slideUp(500,function(){ /*realObj.prev().slideDown(); */ });

	})

	

	j('.tabpopup').mouseenter(function(){

		var e = j.trim(j(this).data('position'))

		switch(e){

			case "left":

				j(this).stop(true, true).animate({'left' : '0'});

				

				break;

			case "right":

				j(this).stop(true, true).animate({'right' : '0'});

				

				break;

			case "top":

				j(this).stop(true, true).animate({'top' : '0px'});

				

				break;

			case "bottom":

				j(this).stop(true, true).animate({'bottom' : '-60px'});

				

				break;

		}

	}).mouseleave(function(){

		var e = j.trim(j(this).data('position'))

		var property = {};

		switch(e){

			case "left":

				j(this).stop(true, true).animate({'left' : -(j(this).width() / 2) + 'px'});

				

				break;

			case "right":

				j(this).stop(true, true).animate({'right' : -(j(this).width() / 2) + 'px'});

				

				break;

			case "top":

				j(this).stop(true, true).animate({'top' : -(j(this).height() / 2) + 'px'});

				

				break;

			case "bottom":

				j(this).stop(true, true).animate({'bottom' : -(j(this).height() / 2) + 'px'});

				

				break;

		}

	})

	

	function urlfilter(str){

		var urlregex = new RegExp("^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");

		

		if (urlregex.test(str)) {

			return (true);

		}

		

		return (false);

	}

	

	function onSpritzifySuccess(spritzText) {

		if(j(".lastClick").length > 0){

			j(".lastClick").find(".spritzer").data("controller").startSpritzing(spritzText);

			j(".lastClick").removeClass("lastClick");

		}else{

			j(".spritzer").data("controller").startSpritzing(spritzText);	

		}

	}

	

	function getSelector(selector){

		if(selector.charAt(0)===','){

			selector = selector.slice(1);

		}

		

		return selector;

	}

	

	function onSpritzifyError(error) {

		console.log("Unable to Spritz: " + error.message);

	}

	

	var customOptions_b = jQuery.extend(true, {}, customOptions);



	j.fn.whenResize = function(){

		var width=parseInt(j(window).width());

		var av=parseInt(800);

		var res="N";

		var _width = j(".spritzer-canvas-container").width();

		

		customOptions_b.redicleWidth=(_width < 150) ? customOptions_b.redicleWidth : _width;

		

		j.each(j(".spritzer"),function(){

			j(this).data("controller").applyOptions(customOptions_b);

			

							selector = (typeof(j(this).data('selector')) != 'undefined') ? j(this).data('selector') : '';

			

			if(selector == ''){

				if("p" != ''){

					selector = 'p';

				}else{

					selector = '';

				}

			}else{

				selector = selector;

			}

			

			url = (typeof(j(this).data('url')) != 'undefined') ? j(this).data('url') : '';

			var urls="<?php echo SPRITZ__PLUGIN_URL; ?>wp.spritz.content.filter.php?url="+url+"&selector=<?php echo $region; ?>&tages=.yoko-spritz-container";

			

			j(this).data("controller").loadText(false, {url:urls,selector:selector})

			

						})

	}

	

	j(window).resize(function(){

		j().whenResize();

	})

	

	j().whenResize();



	j('.spritz-toggle .toggle-anchor').click(function(){

		var get_spritz_id = j(this).attr('id');

		j('.spritzer_popup').toggle('slideup');

		var maximize_btn = "<div class='max-spritz-btn'><div class='max-spritz-plus'>+</div><span>Speed Read with Spritz</span></div>";



		if(j('.spritz-toggle a').html() == "- Minimize Spritz Reader"){

			j('.spritz-toggle a').html(maximize_btn);

			j('.spritz-toggle').css("margin", "0px 0px 25px");

			j.cookie("toggle-state", 1, {expires: 7, path:'/'});

		}else{

			j('.spritz-toggle a').html("- Minimize Spritz Reader");

			j('.spritz-toggle').css("margin", "0px auto 25px");

			j.cookie("toggle-state", 0, {expires: 7, path:'/'});

		}

		return false;

	});



	if(j.cookie){

		if(j.cookie("toggle-state") == 1){

        	j('.spritzer_popup').hide();

        }else{

            j('.spritzer_popup').show();

        }

    }



});