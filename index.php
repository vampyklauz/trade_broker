<script src="jquery.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"></link>
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css"></link>
<script src="bootstrap/js/bootstrap.min.js"></script>
<br><br>
<div class="row" >
	
	<div class="col-xs-6">
		Capital: <input type="text" id="capital">
		<br><br>
		Value: <input type="text" id="value2">
		INCOME >: <input type="text" id="income2" value="400">
		<input type="submit" value="Calculate" id="calculate2">
		<br><br>
		<br><br>
		You must buy greater than a
		<br>
		Volume of: <span id="volumeof"></span><br>
		Change of: <span id="changeof"></span><br>
		Income: <span id="incomeof"></span>
		<br><br>
		OR
		<br>
		Volume of: <span id="volumeof2"></span><br>
		Change of: <span id="changeof2"></span><br>
		Income: <span id="incomeof2"></span>
	</div>
	<div class="col-xs-6">
		<br><br>
		Value: <input type="text" id="value">
		Change: <input type="text" id="change">
		<input type="submit" value="Calculate" id="calculate">
		<br><br>
		Volume: <input type="text" id="volume_data">
		<input type="submit" value="Clear" id="clear_volume">

		<br><br><br>
		VOLUME: <span id="volume"></span>
		<br>
		INCOME: <span id="income"></span>
	</div>
</div>


<script>
		
	$('#calculate').click(function () {
		 calculate();
	})

	$('#value, #change, #volume_data').keypress(function(e) {
	    if(e.which == 13) {
	       calculate();
	    }
	});

	$('#clear_volume').click(function(){
		$('#volume_data').val('');
	})

	$('#calculate2').click(function(){
		calculate2();
	});

	$('#value2, #income2').keypress(function(e) {
	    if(e.which == 13) {
	       calculate2();
	    }
	});

	function calculate2(){
		var capital2 = $('#capital').val();
		var value2 = $('#value2').val();
		var income2 = $('#income2').val();
		var result = [];
		var result2 = [];
		for (var i = .02; i <= 2; i += .01 ) {
			var change2 = parseFloat(i.toFixed(2));
			var volume = capital2 / value2;
			var c_income = volume * change2;
			result = [volume,c_income,change2];
			if( c_income > income2 ) { break; }
		}

		for (var i = .02; i <= .6; i += .01 ) {
			var change2 = parseFloat(i.toFixed(2));
			var volume2 = ( capital2 / value2 ) /2;
			var c_income2 = volume2 * change2;
			result2 = [volume2,c_income2,change2];
			if( c_income2 > income2 ) { break; }
		}
		console.log(result);
		$('#volumeof').html( addCommas(parseInt(result[0]).toFixed(2)) );
		$('#changeof').html( result[2] );
		$('#incomeof').html( addCommas(parseInt(result[1]).toFixed(2)) );

		$('#volumeof2').html( addCommas(parseInt(result2[0]).toFixed(2)) );
		$('#changeof2').html( result2[2] );
		$('#incomeof2').html( addCommas(parseInt(result2[1]).toFixed(2)) );

	}


	function calculate(){
		var capital = $('#capital').val();
		var value = $('#value').val();
		var change = $('#change').val();
		var volume_data = $('#volume_data').val();


		var volume = (volume_data) ? volume_data : capital / value;
		var income = volume * change;
		console.log(volume);
		$('#volume').html(addCommas(parseInt(volume).toFixed(2)));
		$('#income').html(addCommas(parseInt(income).toFixed(2)));
	}

	function addCommas(nStr)
	{
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}
</script>