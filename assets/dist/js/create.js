$(function(){
	var itemlist = $('#itemlist');
	var count = $('#itemlist p').size();
	
	// Adding new items
	$('#additem').click(function(){
		$('<p><input type="text" class="form-control itemname" name="items[]" placeholder="Item name"><span class="dollarsign">$</span><input type="text" class="form-control itemcost" name="itemcosts[]" placeholder="Price"><label><a href="#" type="button" class="close remitem">x</a></label></p>').appendTo(itemlist);
		count++;
		console.log(count);
		removeItem();
		return false;
	});

	// Removing items
	
	function removeItem(){
		$('.remitem').click(function(){
			if(count > 1) {
				$(this).parents('p').remove();
				count--;
				console.log("reduced 1");
			} else {
				console.log("failed count check");
			}
			return false;
		});
	}
});