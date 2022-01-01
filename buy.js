var purchase = document.getElementById('purchase').value;
var balance = document.getElementById('balance').value;	

class Buy {		
	constructor(product_id, product_price) {
		this.product_id = product_id;
		this.product_price = product_price;
	}
	
	amount_of_bought_product(){		
		var cart = parseInt(document.getElementById(this.product_id).value) + 1;	
		document.getElementById(this.product_id).value = cart;	
	}
	
	balance(){
		var last_result = balance - this.product_price;  
		document.getElementById('balance').value = last_result.toFixed(2);			
	}
	
	total_purchase_cost(){
		purchase = parseFloat(purchase) + parseFloat(this.product_price);
		document.getElementById('purchase').value = purchase.toFixed(2);
	}
}

function add_product() {
	var product_id = event.srcElement.id.slice(0, -4).substring(6), 
	product_price = document.getElementById(event.srcElement.id.slice(0, -4)).textContent;
	balance = document.getElementById('balance').value;
	let buy = new Buy(product_id,product_price);
	if(balance - product_price < 0){
		alert("Not enough money");
	}else{
		buy.amount_of_bought_product();
		buy.balance();
		buy.total_purchase_cost();
	}
}