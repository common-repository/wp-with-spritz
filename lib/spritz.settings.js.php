<script type="text/javascript">
	var SpritzSettings = {
		clientId					: "<?php echo $spritz_client_id; ?>",
		redirectUri					: "<?php echo SPRITZ__PLUGIN_URL; ?>wp.spritz.login.success.html",
		};
		var items = eval("[50,100,150,250,300,350,400,450,500,550,600,650,700,750,800,850,900,950,1000]");
		var customOptions = {
		redicleWidth 				: 370,
		redicleHeight 				: 50,
		speedItems 					: items,
		"defaultSpeed"				: 250,
		placeholderText				:
		{
			startText 				: '<?php echo $spritz_start; ?>',
			endText					: '<?php echo $spritz_end; ?>',
		},
		"controlButtons" 			: ["rewind","back","pauseplay","forward"],
		"controlTitles" 			:
		{
			"pause" 				: "Pause",
			"play" 					: "Play",
			"rewind" 				: "Rewind",
			"back" 					: "Previous Sentence",
			"end"					: "Go to End",
			"forward"				: "Forward"
		},
		redicle: {
			backgroundColor 		: "#fff",
			textNormalPaintColor 	: "#333",
			textHighlightPaintColor : "#cc0001", // Red ORP
			redicleLineColor 		: "#000",
			redicleLineWidth		: 1,
			countdownTime			: 750,                 	// milliseconds
			countdownSlice			: 5,                  	// milliseconds
			countdownColor			: "rgba(0,0,0,0.1)"   	// rgba colors work too
		}
		
	}
</script>