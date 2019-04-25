$(document).ready(function(){
	
	console.log("DOM Listo!");
	$("input[name='file']").on("change", function(){
        var formData = new FormData($("#formulario")[0]);
        image = formData;
        $.ajax({
            url: "ajax/actions_products.php?action=load-image",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(datos){
               $("#respuesta").html(datos);
            }
        });
    });
	
	$("#btn-save").click(function(){

        var errors = validate();

        if(!errors == ""){
            alert(errors);
            return;
        }

		var params = "slc-depto=" +$("#slc-depto").val() + "&name="+$("#name").val()+
					 "&description="+$("#description").val() + "&price="+$("#price").val()+
					 "&discount="+$("#discount").val() + "&tax="+$("#tax").val()+ "&cant="+$("#cant").val();
		$.ajax({
            url: "ajax/actions_products.php?action=save",
            type: "POST",
            data: params,
            dataType: 'json',
            success: function(datos){
               //$("#respuesta").html(datos);
               if(datos.status == 200){
                    alert(datos.data);
                    window.location = "products.php";
               }
            }
        });
	});
});

validate = function(){
    var errors = "";

    if($("#slc-depto").val() === null){
        errors += "Debe seleccionar un departamento\n";
    }
    if($("#name").val() === ""){
        errors += "Debe ingresar el nombre del producto\n";
    }
    if($("#description").val() === ""){
        errors += "Debe ingresar una descripcion del producto\n";
    }

    if($("#cant").val() === ""){
        errors += "Debe ingresar la cantidad de producto\n";
    }

    var re = new RegExp(/[+-]?([0-9]*[.])?[0-9]+/);
    if ($("#price").val().match(re)) {
      console.log("si es float");
    }else{
        errors += "Debe ingresar un precio válido\n";
    }

    if ($("#tax").val().match(re)) {
      console.log("si es float");
    }else{
        errors += "Debe ingresar un impuesto válido\n";
    }

    if ($("#discount").val().match(re)){
      console.log("si es float");
    }else{
        errors += "Debe ingresar un descuento válido\n";
    }

    if($("#file").val() === ""){
        errors += "Debe seleccionar una imagen";
    }
    return errors;
}