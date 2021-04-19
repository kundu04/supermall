(function ($) {
 "use strict";
    
		//---------------------------------------------
		//Nivo slider
		//---------------------------------------------
			 $('#ensign-nivoslider').nivoSlider({
				effect: 'random',
				slices: 15,
				boxCols: 8,
				boxRows: 4,
				animSpeed: 500,
				pauseTime: 5000,
				directionNav: true,
				controlNav:true,
				randomStart:true,
				controlNavThumbs: false,
				pauseOnHover: true,
				manualAdvance: true,
				prevText: '<i class="fa  fa-angle-left"></i>', 
    			nextText: '<i class="fa  fa-angle-right"></i>',
			 });
			 
			
})(jQuery); 