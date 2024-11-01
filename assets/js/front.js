var j = jQuery.noConflict();
var url;
var selector;

j(document).ready(function(){
	
	j.each(j(".spritzer"),function(){
		
		selector=(typeof(j(this).data('selector')) != 'undefined') ? j(this).data('selector'):'';
		
		if(selector==''){
			if("p" != ''){
				selector='p';
			}else{
				selector='';
			}
		}else{
			selector=selector;
		}
		
		url = (typeof(j(this).data('url')) != 'undefined') ? j(this).data('url'):'';
		var urls="/wp-content/plugins/spritz/wp.spritz.content.filter.php?url="+url+"&selector=<?php echo $region; ?>&tages=.yoko-spritz-container";
		
		//j(this).data("controller").applyOptions(customOptions)
		j(this).data("controller").loadText(false, {url:urls,selector:selector})
		
	})
	
	
})