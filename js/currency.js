// str example: 1.000.000
function currencytonum(str)
{
	if (str == "") return 0;

	// replace all dot to blank
	str = str.replace(/\./g, "");
	
	// str to int
	return parseInt(str);
}

// output example: 1.000.000
function numtocurrency(num)
{
	num = num.toString().replace(/\$|\,/g,'');
	
	if (isNaN(num)) num = "0";
	
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num * 100 + 0.50000000001);
	cents = num % 100;
	num = Math.floor(num / 100).toString();
	
	if (cents < 10) cents = "0" + cents;
	
	for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
		num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
		
	return (((sign) ? '' : '-') + num );
}

function numeric()
{
	$(".numeric").keydown(function(event) {
		// Allow: backspace, delete, tab, escape, and enter
		if (event.keyCode == 116 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
			 // Allow: Ctrl+A
			(event.keyCode == 65 && event.ctrlKey === true) || 
			 // Allow: home, end, left, right
			(event.keyCode >= 35 && event.keyCode <= 39) || event.keyCode == 190 || event.keyCode == 110|| event.keyCode == 188) {
				 // let it happen, don't do anything
				return;
		}
		else {
			// Ensure that it is a number and stop the keypress
			if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
				event.preventDefault(); 
			}   
		}
	});
}