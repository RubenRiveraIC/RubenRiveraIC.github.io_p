
$(document).ready(function() {
  
    // Testing Jquery
    

    
      const id = 1;
      var d2;
      $.post('funcs/idSensores.php', {id}, (response) => {
        //console.log(response)
        let ids = JSON.parse(response);
        Datos(ids[0].idSensor);
        
        // for (let i = 0; i < ids.length; i++) {
          
        //     Datos(ids[i].idSensor);
        //     // ids[i].tipoSensorTexto 
          
        //   // id_S[i] = ids[i].idSensor;
        // }
        
    
     
      });
        
      function Datos(id_S){
        $.post('funcs/fetchDatosLH.php', {id_S}, (response) => {
          ExtD(response);
        });
    
      }

      function ExtD(datos){
        console.log(datos)
         var datosS = jmespath.search(JSON.parse(datos), "[::-1] | [*].fecha");

        console.log(datosS)
    
      }
     
   

});