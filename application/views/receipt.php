
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>WhoPay</title>
	<meta name="description" content="A Simple, Elegant &amp; Flat Bootstrap Theme">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/assets/dist/css/paper.css">
	<link rel="stylesheet" href="/assets/assets/css/style.css">
	<link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
</head>

<body>


	<!-- Main menu -->
	<div class="container">
		<div class="row" style="margin-top: 50px;">
			<div class="col-md-6 col-md-offset-3">
				<div class="text-center">
					<h1><a href="/" style="text-decoration:none; color:black;">WhoPay</a></h1>
					<h4>Access code: <b><?= $receiptCode ?></b></h4>
					<h3><span style="color:green; font-weight:bold;">Tap</span> on items you want to pay for</h3>
					<hr>
					<form action="/index.php/main/ready" method="post">
						<input type="hidden" name="userId" value="<?= $userId ?>">
						<?php foreach ($items as $item): ?>
						    <span class="button-checkbox">
						        <input type="checkbox" class="hidden" name="itemId" value="<?= $item->id ?>"/>
						        <button type="button" class="btn btn-block" data-color="success" style="margin-bottom:5px;"><span class="pull-left"><?= $item->name ?></span><span class="pull-right">$<?= number_format(round($item->cost, 2, PHP_ROUND_HALF_UP), 2, '.', '') ?></span></button>
						    </span>
						<?php endforeach; ?>
						<button id="ready" type="submit" class="btn btn-primary">Ready</button>
						<a href="/index.php/main/result/<?= $receiptCode ?>" id="submit" class="btn btn-default disabled">Submit</a>
					</form>
				</div>
				<hr>
			</div>
		</div>
	</div>

	<br><br>
	<!-- Footer -->
	<div class="container">
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1 text-center"> 
				<span>Built on <a href="http://getbootstrap.com/">Bootstrap</a></span> |
				<span>Github: <a href="https://github.com/kiangkuang/WhoPay">WhoPay</a></span>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="/assets/dist/js/vendor/jquery.min.js"></script>
	<script type="text/javascript" src="/assets/dist/js/paper.min.js"></script>
	<script type="text/javascript">
		window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
	</script>
	<script type="text/javascript" src="https://apis.google.com/js/platform.js" async defer></script>
	<script>
		$(function () {
		    $('.button-checkbox').each(function () {

		        // Settings
		        var $widget = $(this),
		            $button = $widget.find('button'),
		            $checkbox = $widget.find('input:checkbox'),
		            color = $button.data('color');

		        // Event Handlers
		        $button.on('click', function () {
		            $checkbox.prop('checked', !$checkbox.is(':checked'));
		            $checkbox.triggerHandler('change');
		            updateDisplay();
		        });
		        $checkbox.on('change', function () {
		            updateDisplay();
		        });

		        // Actions
		        function updateDisplay() {
		            var isChecked = $checkbox.is(':checked');

		            // Set the button's state
		            $button.data('state', (isChecked) ? "on" : "off");

		            // Update the button's color
		            if (isChecked) {
		                $button
		                    .removeClass('btn-default')
		                    .addClass('btn-' + color + ' active');
		            }
		            else {
		                $button
		                    .removeClass('btn-' + color + ' active')
		                    .addClass('btn-default');
		            }
		        }

		        // Initialization
		        function init() {
		            updateDisplay();
		        }
		        init();
		    });
		});
	</script>
	<script>
		var readied = 0;
		var total = 0;
		// Attach a submit handler to the form
		$( "form" ).submit(function( event ) {
		 
		  // Stop form from submitting normally
		  event.preventDefault();
		 
		  // Get some values from elements on the page:
		  var $form = $( this );
		  var userId = $form.find( "input[name='userId']" ).val();
		  var checked = $("input:checked");
		  var buttonArray = $("input + button");
		  var items = [];
		  for (var i = 0; i <checked.length; i++) {
		  	items[i] = $(checked[i]).val();
		  };
		  var url = $form.attr( "action" );
		 
		  // Send the data using post
		  var posting = $.post( url, { userId: userId, items: items } );
		 
		  posting.done(function( data ) {
		  	if ($('#ready').html() == 'Ready') {
			  	$('#ready').html('Unready');
			  	$('form').attr('action', '/index.php/main/unready');

				for (var i = 0; i <buttonArray.length; i++) {
				  	$(buttonArray[i]).addClass('disabled');
				}
				readied++;
				if (readied == total) {
				  	$('#submit').html('Submit').removeClass('disabled');
				}
				$('#submit').removeClass('btn-default').addClass('btn-primary');
				$('#ready').removeClass('btn-primary').addClass('btn-default');
			} else if ($('#ready').html() == 'Unready') {
			  	$('#ready').html('Ready');
			  	$('form').attr('action', '/index.php/main/ready');

				for (var i = 0; i <buttonArray.length; i++) {
				  	$(buttonArray[i]).removeClass('disabled');
				}
				readied--;
				$('#submit').html('<img src="/assets/img/loading.gif" style="height:20px;"> ' + readied + '/' + total + ' Readied').addClass('disabled').removeClass('btn-primary').addClass('btn-default');
				$('#ready').removeClass('btn-default').addClass('btn-primary');
			}
		  });
		});

		if(typeof(EventSource) !== "undefined") {
		    var source = new EventSource("/index.php/main/status");
		    source.onmessage = function(event) {
		        var data = JSON.parse(event.data);
		        readied = data.readied;
		        total = data.total;
		        submitted = data.submitted;
		        if (readied != total) {
				  	$('#submit').html('<img src="/assets/img/loading.gif" style="height:20px;"> ' + data.readied + '/' + data.total + ' Readied').addClass('disabled');
				} else {
				  	$('#submit').html('Submit').removeClass('disabled');
				}
				if (submitted == 1) {
					window.location.href = $('#submit').attr('href');
				}
		    };
		} else {
		    console.log(event.data);
		}
	</script>
</body>
</html>