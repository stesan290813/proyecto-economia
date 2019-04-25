$(document).ready(function(){
    
    $.ajax({
        url:"ajax/actions_products.php?action=orders",
        data: "",
        method: "POST",
        success:function(response){
            //console.log(response);
            $("#respuesta").html(response);
        },
        error:function(e){
            console.log("Error: "+e);
        }
    });
        
    $("#btn-buy").click(function(){
        $.ajax({
            url:"ajax/actions_products.php?action=buy",
            data: "",
            method: "POST",
            dataType: 'json',
            success:function(response){
                if(response.status == 200){
                    alert(response.data);
                    window.location = "products.php";
                }else{
                    alert(response.error);
                }
            },
            error:function(e){
                console.log("Error: "+e);
            }
        });
	});
});