$(document).ready( function(){

	$("#btn-save").click(function(){
		var errors = validate();

		if(!errors == ""){
			$("#response").css("display", "block");
			$("#response").fadeIn(100);
			$("#response").html(errors);
			$("#response").fadeOut(3000);
			return;
		}

		var params = "name=" +$("#name").val() + "&last="+$("#last").val()+
					 "&email="+$("#email").val() + "&country="+$("#country").val()+
					 "&phone="+$("#phone").val() + "&money="+$("#money").val() + "&password="+$("#password").val();
		$.ajax({
			url:"ajax/actions_login.php?action=save",
			method: "POST",
			data: params,
			success:function(response){
				if(response == "success"){
					alert("Te has registrado correctamente!");
					window.location="index.php";
				}
			},
			error:function(e){
				console.log("Error: "+e);
			}
		});
	});

});

validate = function(){
	var errors = "";
	if($("#name").val() === ""){
		errors += "<b>Nombre</b> vacio<br>";
	}
	if($("#last").val() === ""){
		errors += "<b>Apellido</b> vacio<br>";
	}
	if($("#email").val() === ""){
		errors += "<b>Email</b> vacio<br>";
	}
	if($("#phone").val() === ""){
		errors += "<b>Telefono</b> vacio<br>";
	}
	if($("#money").val() === ""){
		errors += "<b>Monto Inicial</b> vacio<br>";
	}
	if($("#password").val() === ""){
		errors += "<b>Contraseña</b> vacio<br>";
	}
	if($("#password2").val() === ""){
		errors += "<b>Confirmar Contraseña</b> vacio<br>";
	}
	if($("#password").val() != $("#password2").val()){
		errors += "<b>Las contraseñas no coinciden!</b>";
	}
	return errors;
}