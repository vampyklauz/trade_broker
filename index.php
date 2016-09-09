<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Trade Broker</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="content col-xs-12">
		<div class="row">
			<div class="col-xs-6">
			<h3 class="text-success">Buying Calculator</h3>
			<div class="form-horizontal">
				<div class="form-group">
					<label for="capital" class="col-sm-2 control-label">Cash</label>
					<div id="capital_wrapper" class="col-sm-10">
						<input type="text" class="form-control" id="capital" placeholder="Investment" autofocus>
						<p class="display_capital hide"><span id="capital_view"></span><i class="edit glyphicon glyphicon-edit" aria-hidden="true"></i></p>
					</div>
					
				</div>
				<div class="form-group">
					<label for="b_value" class="col-sm-2 control-label">BUY</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="b_value" placeholder="Current Price">
					</div>
					<label for="b_change" class="col-sm-2 control-label">SELL</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="b_change" placeholder="Price Change">
					</div>
				</div>
				<div class="form-group">
					<label for="b_volume" class="col-sm-2 control-label">Shares</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="b_volume" placeholder="Stocks">
					</div>
					<button id="clear_volume" class="btn btn-warning" type="submit">Clear</button>
					<div class="col-xs-2 pull-right">
						<button id="b_calculate" class="btn btn-success pull-right" type="submit">Calculate</button>
					</div>
				</div>
			</div>

			<div id="buying_view" class="col-xs-12">
				<h4 id="b_volume_view" class="text-success hide">Volume: &nbsp;&nbsp;<span></span></h4>
				<h4 id="b_income_view" class="text-success hide">Income: &nbsp;&nbsp;<span></span></h4>
			</div>
			</div>
			<div class="col-xs-6">
				<h3 class="text-primary">Expected Income Calculator</h3>
				<div class="form-horizontal">
				<div class="form-group">
					<label for="e_value" class="col-sm-2 control-label">Value</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="e_value" placeholder="Current Price">
					</div>
					<label for="e_income" class="col-sm-2 control-label">Income ></label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="e_income" placeholder="Expected Income">
					</div>

				</div>
				<button id="e_calculate" class="btn btn-success pull-right" type="submit">Calculate</button>

				<div class="col-xs-12">
					<h5>You must buy greater than a </h5>
					<div class="col-xs-6">
						<h4 id="e_volume_view" class="text-primary hide">Volume of: &nbsp;&nbsp;<span></span></h4>
						<h4 id="e_change_view" class="text-primary hide">Change of: &nbsp;&nbsp;<span></span></h4>
						<h4 id="e_income_view" class="text-primary hide">Income: &nbsp;&nbsp;<span></span></h4>
					</div>
					<div class="col-xs-6">
						<h4 id="e_volume2_view" class="text-primary hide">Volume of: &nbsp;&nbsp;<span></span></h4>
						<h4 id="e_change2_view" class="text-primary hide">Change of: &nbsp;&nbsp;<span></span></h4>
						<h4 id="e_income2_view" class="text-primary hide">Income: &nbsp;&nbsp;<span></span></h4>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</body>
</html>

<script>
	$(function() {
	  $('.form-horizontal, #capital_wrapper').on('keydown', 'input', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
	})
	$('#capital').focusout(function() {
		var capital = $(this).val();
		if( capital == '' ){
			var r = prompt("Please input your Capital first");
			capital = r;
		}
		if( capital && $.isNumeric(capital) ){
			capital = currency(capital);
			$(this).hide();
			$('.display_capital').removeClass('hide');
			$('#capital_view').html(capital);
		}else{
			alert('Please input a number')
		}
	});

	$('.edit').click(function(){
		$('.display_capital').addClass('hide');
		$('#capital').show().focus().select();
	});

	$('#clear_volume').click(function(){
		$('#b_volume').val('');
	});

	$('#b_calculate').click(function(){
		calculate();
	});

	$('#b_value, #b_change, #b_volume').keypress(function(e) {
	    if(e.which == 13) {
	       calculate();
	    }
	});

	$('#e_calculate').click(function(){
		e_calculate();
	});

	$('#e_value, #e_income').keypress(function(e) {
	    if(e.which == 13) {
	       e_calculate();
	    }
	});

	function e_calculate(){
		var min = .01,
			max = 2,
			capital = $('#capital').val(),
			e_value = $('#e_value').val(),
			e_income = $('#e_income').val(),
			result = [],
			result2 = [];

		if( capital ){
			if( e_value && e_income ){

				for( var i = min; i <= max; i+= .01){
					var e_change = parseFloat(i.toFixed(2));
					var e_volume = capital / e_value;
					var res_income = e_volume*e_change;
					result = [e_volume,e_change,res_income];
					if( res_income > e_income){break;}
				}

				for( var i = min; i <= max; i+= .01){
					var e_change2 = parseFloat(i.toFixed(2));
					var e_volume2 = ( capital / e_value ) /2;
					var res_income2 = e_volume2*e_change2;
					result2 = [e_volume2,e_change2,res_income2];
					if( res_income2 > e_change2){break;}
				}
				$('#e_volume_view, #e_change_view, #e_income_view').removeClass('hide');
				$('#e_volume_view>span').html(currency(result[0]));
				$('#e_change_view>span').html( (parseFloat(e_value)+parseFloat(result[1])) );
				$('#e_income_view>span').html(currency(result[2]));

				$('#e_volume2_view, #e_change2_view, #e_income2_view').removeClass('hide');
				$('#e_volume2_view>span').html(currency(result[0]));
				$('#e_change2_view>span').html( (parseFloat(e_value)+parseFloat(result[1])) );
				$('#e_income2_view>span').html(currency(result[2]));

			}else{
				alert('Value and Income are important')
			}
		}else{
			alert('Please input your Capital first');
		}

	}

	function calculate(){
		var capital = $('#capital').val(),
			b_value = $('#b_value').val(),
			b_change = $('#b_change').val(),
			b_volume = $('#b_volume').val();

		if( capital ){
			if( b_value && b_change ){
				var volume = (b_volume) ? b_volume : capital / b_value;
				var spent_raw = volume*b_value;
				var sell_raw = volume*b_change;
				var spent = spent_raw+(spent_raw*.00295);
				var sell = sell_raw-(sell_raw*.00795);
				var income = sell-spent;
				/*$('#b_volume_view').removeClass('hide');
				$('#b_volume_view>span').html(currency(volume));
				$('#b_income_view').removeClass('hide');
				$('#b_income_view>span').html(currency(income));*/
				$('#buying_view').html('\
					<h4 class="text-success">Shares: &nbsp;&nbsp;<span>'+volume+'</span></h4>\
					<h4 class="text-success">Spent: &nbsp;&nbsp;<span>'+currency(spent)+'</span></h4>\
					<h4 class="text-success">Sell: &nbsp;&nbsp;<span>'+currency(sell)+'</span></h4>\
					<h4 class="text-success">NET: &nbsp;&nbsp;<span>'+currency(income)+'</span></h4>\
					')
			}else{
				alert('Value and Change are important');
			}
		}else{
			alert('Please input your Capital first');
		}
	}

	function currency(money,sign){
		var currency = sign || 'P ';
		var money = parseInt(money);
		return currency+ money.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
	}
</script>