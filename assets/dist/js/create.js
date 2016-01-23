// Append item to itemlist
$('#additem').click(function(){
    $('#itemlist').append('<input type="text" class="form-control itemname" name="items[]" placeholder="Item name"><input type="text" class="form-control itemcost" name="itemcosts[]" placeholder="Price of Item">');
});