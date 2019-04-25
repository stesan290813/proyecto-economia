$(document).ready( function(){

	$("#login").submit(function(e){
		e.preventDefault();

		$("#btn-login").click(function(){
			var params = "email=" +$("#email").val() + "&password="+$("#password").val();
			$.ajax({
				url:"ajax/actions_login.php?action=verify",
				method: "POST",
				data: params,
				dataType: "json",
				success:function(response){
					if(response.resultado == 'exists'){
						window.location="menu.php";
					}else{
						$("#response").css("display", "block");
						$("#response").fadeIn(100);
						$("#response").html("Usuario/Contraseña Inválidos!");
						$("#response").fadeOut(4000);
					}
					console.log(response);
				},
				error:function(e){
					console.log("Error: "+e);
				}
			});
		});
	});

});