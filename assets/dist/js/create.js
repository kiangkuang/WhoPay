$(function(){
	var itemlist = $('#itemlist');
	var count = $('#itemlist .input-group-addon').size();
	crossVisibility()
	
	// Adding new items
	$('#additem').click(function(){
		$('.remitem').unbind();
		$(itemlist).append('<div class="col-xs-8"><!-- Item Field --><div class="form-group" id="itemlist" style="margin-top: 0px;"><input type="text" class="form-control itemname" name="items[]" placeholder="Item name"></div></div><div class="col-xs-4"><!-- Item Field --><div class="input-group form-group"><div class="input-group-addon">$</div><input type="text" class="form-control" class="form-control itemcost" name="itemcosts[]" placeholder="Price"><a><span style="position:absolute;top:7px;right:-20px;" class="close remitem">&times;</span></a></div></div>');
		count++;
		console.log(count);

		removeItem();
		crossVisibility()
		return false;
	});

	// Removing items
	
	function removeItem(){
		$('.remitem').click(function(){
			if(count > 1) {
				$(this).parents('.item').remove();
				count--;
				console.log("reduced 1");
			} else {
				console.log("failed count check");
			}
			crossVisibility()
			return false;
		});
	}

	function crossVisibility(){
		if (count > 1) {
			$('.remitem').show();
		} else {
			$('.remitem').hide();
		}
	}
});