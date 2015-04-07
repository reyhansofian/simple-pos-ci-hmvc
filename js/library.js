/**
 Custom module for you to write your own javascript functions
 **/
var Library = function () {

    // public functions
    return {

        //main function
        init: function () {
            //initialize here something.
        },

        // wrapper function to  block element(indicate loading)
        blockUI: function (el, centerY) {
            var el = jQuery(el);
            var segment;

            if (el.height() <= 400) {
                centerY = true;
            }

            pathArray = window.location.href.split( '/' );
            protocol = pathArray[0];
            host = pathArray[2];

            if (host == 'localhost') {
                segment = host + '/' + pathArray[3];
            } else {
                segment = host;
            }
            url = protocol + '//' + segment +'/css/ajax-loading.gif';

            el.block({
                message: '<img src="'+url+'">',
                centerY: centerY != undefined ? centerY : true,
                css: {
                    top: '10%',
                    border: 'none',
                    padding: '2px',
                    backgroundColor: 'none'
                },
                overlayCSS: {
                    backgroundColor: '#000',
                    opacity: 0.05,
                    cursor: 'wait'
                }
            });
        },

        // wrapper function to  un-block element(finish loading)
        unblockUI: function (el) {
            jQuery(el).unblock({
                onUnblock: function () {
                    jQuery(el).removeAttr("style");
                }
            });
        },
        
        currency: function number_format(number, decimals, dec_point, thousands_sep) { 
			// Formats a number with grouped thousands 
			// * example 1: number_format(1234,56); 
			// * returns 1: '1.235' 
			// * example 2: number_format(1234.56, 2, ',', ' '); 
			// * returns 2: '1 234,56' 
			// * example 3: number_format(1234.5678, 2, '.', ''); 
			// * returns 3: '1234.57' 
			// * example 4: number_format(67, 2, ',', '.'); 
			// * returns 4: '67.00' 
			// * example 5: number_format(1000); 
			// * returns 5: '1.000' 
			// * example 6: number_format(67,311, 2); 
			// * returns 6: '67,31' 
			// * example 7: number_format(1000,55, 1); 
			// * returns 7: '1.000,6' 
			// * example 8: number_format(67000, 5, ',', '.'); 
			// * returns 8: '67.000,00000' 
			// * example 9: number_format(0,9, 0);
			// * returns 9: '1' 
			// * example 10: number_format('1,20', 2); 
			// * returns 10: '1,20' 
			// * example 11: number_format('1,20', 4); 
			// * returns 11: '1,2000' 
			// * example 12: number_format('1,2000', 3); 
			// * returns 12: '1,200' 
			var n = number, prec = decimals; 
			var toFixedFix = function (n,prec) { var k = Math.pow(10,prec); return (Math.round(n*k)/k).toString(); }; 
			
			n = !isFinite(+n) ? 0 : +n; 
			prec = !isFinite(+prec) ? 0 : Math.abs(prec); 
			var sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep; 
			var dec = (typeof dec_point === 'undefined') ? ',' : dec_point; 
			var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); 
			
			//fix for IE 
			// parseFloat(0.55).toFixed(0) = 0; 
			var abs = toFixedFix(Math.abs(n), prec); 
			var _, i; 
			if (abs >= 1000) {
				_ = abs.split(/\D/); 
				i = _[0].length % 3 || 3; _[0] = s.slice(0,i + (n < 0)) + _[0].slice(i).replace(/(\d{3})/g, sep+'$1'); 
				s = _.join(dec); 
			} else { 
				s = s.replace(',', dec); 
			} 
			
			var decPos = s.indexOf(dec); 
			if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) { 
				s += new Array(prec-(s.length-decPos-1)).join(0)+'0'; 
			} else if (prec >= 1 && decPos === -1) { 
				s += dec+new Array(prec).join(0)+'0'; 
			} 
			
			return s; 
		}
    };

}();

/***
 Usage
 ***/
//Custom.init();
//Custom.doSomeStuff();