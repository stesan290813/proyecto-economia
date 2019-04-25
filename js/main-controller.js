$(document).ready(function(){
	
	console.log("DOM Listo!");
	
	loadData();

	$('#exampleModalCenter').on('shown.bs.modal', function () {
	  $('#btn').trigger('focus')
	});

	$('#login').on('shown.bs.modal', function () {
	  $('#btn').trigger('focus')
	});

	var url = window.location.pathname;
	if(url === "/Amazon/index.php" || url === "/Amazon/"){
		$(".btn-success").click(function(evt){
			//alert("Debe iniciar sesión para realizar la compra!");
			//window.location = "login.php";
		});
	}else{
		var count = 0;
		var ids = [];
		$(".btn-success").click(function(evt){
			var button = $(this).attr("id");
			var reverse = button.split("").reverse().join("");
			var id = reverse.substring(0,1); 
			//console.log(id);
	    	count = count+1;
			$("#count").html(count);
			$("#count2").html(count);
			$("#remove"+id).css("visibility","visible");
			$("#accept"+id).css("visibility","hidden");
			alert("Producto agregado!");
			ids[count-1] = $("#accept"+id).attr('id');
			carritoCompra(ids);
		});

		$(".btn-danger").click(function(evt){
	    	var button = $(this).attr("id");
			var reverse = button.split("").reverse().join("");
			var id = reverse.substring(0,1); 
			//console.log(id);
	    	count = count-1;
			$("#count").html(count);
			$("#count2").html(count);
			$("#accept"+id).css("visibility","visible");
			$("#remove"+id).css("visibility","hidden");
			var pos = ids.indexOf($("#accept"+id).attr('id'));
			var elementoEliminado = ids.splice(pos, 1);
			carritoCompra(ids);
		});
		
	}
	
	$("#search").click(function() {
		search();
	});

	changeSelect();

});

function loadData(){
	$.ajax({
		url:"ajax/actions_products.php?action=count",
		method: "POST",
		dataType: "json",
		success:function(response){
			//console.log(response.cantidad);
		},
		error:function(e){
			console.log("Error: "+e);
		}
	});
}

function search(){
	$.ajax({
		url:"ajax/actions_products.php?action=search",
		data: "product="+$("#product").val(),
		method: "POST",
		dataType: 'json',
		success:function(response){
			if(response.status == 500){
				$("#photo").attr("src", "img/not_found.svg");
				$("#name").html("Ninguno");
				$("#description").html("Ninguna");
				$("#depto").html("Ninguno");
				$("#price").html("$ 0.00");
			}else{
				console.log(response.name);
				$("#photo").attr("src", response.photo);
				$("#name").html(response.name);
				$("#description").html(response.description);
				$("#depto").html(response.depto);
				$("#price").html("$ "+response.price);
			}
		},
		error:function(e){
			console.log("Error: "+e);
		}
	});
}

function changeSelect(){

	$("#slc-depto").change(function(){
        var select = "id="+this.value;
        
        $.ajax({
			url:"ajax/actions_products.php?action=index",
			data: select,
			method: "POST",
			success:function(response){
				//console.log(response);
				//console.log(response);

				$(".row").empty();

				$(".row").html(response);
			},
			error:function(e){
				console.log("Error: "+e);
			}
		});
	});
}

function carritoCompra(ids){
	console.log(ids);
	var products = "ids[]="+ids;
	$.ajax({
		url:"ajax/actions_products.php?action=shop",
		data: products,
		method: "POST",
		success:function(response){
			console.log(response);
		},
		error:function(e){
			console.log("Error: "+e);
		}
	});
}