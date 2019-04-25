var db = "amazon";
var version = 1;

(function(){
    if (!('indexedDB' in window)){
        console.err("El navegador no soporta indexedDB");
        return;
    }

    var solicitud = window.indexedDB.open(db, version);
    
    //Se ejecutara en caso de que pueda abrir la BD sin problemas
    solicitud.onsuccess = function(evento){
        console.log("Se abrio la base de datos");
        db = solicitud.result;
        //Leer la informacion del objectstore e imprimirla en la tabla html
        //llenarIndex();
        guardarIndex();
        
    };
    

    //Se ejecutar en caso no se pueda abrir la base de datos
    solicitud.onerror = function(evento){
        console.err("No se pudo abrir la base datos");
    };

    //Se ejecutara cuando NO exista la base de datos o se necesite actualizar
    solicitud.onupgradeneeded = function(evento){
        console.log("Se creará la DB");
        db = evento.target.result; //Obteniendo la refencia la base de datos creada (amazon)
        var objectStoreproductos = db.createObjectStore("productos", {keyPath: "codigo", autoIncrement: true});
        
        objectStoreproductos.transaction.oncomplete = function(evento){
            console.log("El object store de productos se creo con exito");
        }

        objectStoreproductos.transaction.onerror = function(evento){
            console.log("Error al crear el object store de productos");
        }

    }
    
})();


function guardarIndex(){
    
  $.ajax({
      url:"ajax/actions_products.php?action=indexedDB",
      method: "POST",
      success:function(response){
          //console.log(response);
          var producto = {response};
          //producto.html = response;
          ///Guardar informacion en el objectstore de productos de la base de datos de amazon
          var transaccion = db.transaction(["productos"],"readwrite");
          var objectStoreproductos = transaccion.objectStore("productos");
          var solicitud = objectStoreproductos.add(producto);
          solicitud.onsuccess = function(evento){
              console.log("Se agrego el producto correctamente");
              //llenarIndex();
          }

          solicitud.onerror = function(evento){
              console.log("Ocurrio un error al guardar");
          }

          console.log(producto);
      },
      error:function(e){
          console.log("Error: "+e);
      }
  });
}


function llenarIndex(){

    var transaccion = db.transaction(["productos"],"readonly");
    var objectStoreproductos = transaccion.objectStore("productos");
    var cursor = objectStoreproductos.openCursor();

    cursor.onsuccess = function(evento){
        //Se ejecuta por cada objeto del objecstore
        if(evento.target.result){
            console.log(evento.target.result.value);
            if (document.getElementById("respuesta") !=null)
                document.getElementById("respuesta").innerHTML += evento.target.result.value.html;
            evento.target.result.continue();
        }
    }
}