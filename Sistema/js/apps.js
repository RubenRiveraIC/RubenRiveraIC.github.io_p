
$(document).ready(function() {
  //Variables Globales//
  if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('./sw.js')
    .then(reg => console.log('Registro de SW exitoso', reg))
    .catch(err => console.warn('Error al tratar de registrar el sw', err))
}  
  var id,id_S,nameID,id_D,NS,TPS,typeID;
  let myChart;
  // let labelS = "hola mundo";
  let template= "";
  let templateBC1,templateBC_base,templateBC="";
  let AUX = 0;
  var datos1;
  let CC=0;
  let TP = 2;
  let TPC = 0;
  let movil = 0;
  let labelSS = [];
  let ColorS =[];
  const ColorBS = {
    1 : 'rgba(199, 50, 254, 1)',
    2 : 'rgba(0, 100, 255, 1)',
    3 : 'rgba(51, 100, 97,1)'
  }
  moment.locale('es-mx');
  ismovil();
  deshabilitaRetroceso();
  
  /*----------------------------------*/
  // obtiene la ruta de la imagen del sistema y la inserta en el menubar
  $.post('funcs/fetchSystem.php', {}, (response) => {
        const sis = JSON.parse(response);
        $("#imgsis").prop('src',"https://images.htech.mx/avatars/"+sis[0].logo);
        $('#namesis').html(sis[0].nombre);
  });
  /*----------------------------------------------------------------------------*/
  /*Remueve la clase active a todos los elementos pertenecientes a la clase nav-link 
  y se la asigna solo a la clase nav-link.Dash*/
   $('.nav-link').removeClass('active');
   $('.nav-link.dash').addClass('active'); 
  /*-------------------------------------------------------------------------------*/
  // Oculta el canvas vacio de la Grafica
  $('#Grafica').hide();
  //Oculta la pantalla de carga despues de 6s
  $('#LD').hide();
  // setTimeout(myFunction, 6000);

  // document.getElementById("breadC").style.display = "none";
  /*------------------------------------*/
  // Decide el templateBC_base que se usara para las breadcrums segun sea el caso (fuentes o redes)
    $(document).on('click', '.Fuentes', function(){
      templateBC_base = `
                    <li class="breadcrumb-item"><a href="principal.php">Inicio</a></li>
                    <li class="breadcrumb-item">Fuentes de Agua</li>          
                    `
    });
    $(document).on('click', '.Redes', function(){
      templateBC_base = `
                    <li class="breadcrumb-item"><a href="principal.php">Inicio</a></li>
                    <li class="breadcrumb-item">Redes de Agua</li>          
                    `
    });
  /*---------------------------------------------------------------------------------------------*/
  // Unifica el templateBC_base y el templateBC1 para crear el template para las breadcrums
    $(document).on('click', '.FR_G', function(){
        templateBC1 = templateBC_base + `
                    <li class="breadcrumb-item">${$(this).html().slice(0, -542)}</li>          
                    `
    });
  /*--------------------------------------------------------------------------------------*/
  // Detecta el evento click en los elementos pertenecientes a la clase FRGrupo
    $(document).on('click', '.FRGrupo', function(){
      if(movil==true){
        $('.sb-nav-fixed').removeClass('sb-sidenav-toggled');
      }
      
      // Obtiene el id del elemento clickeado
      id = $(this).attr('id');
      /*-----------------------------------*/
      // muestra la pantalla de carga (mas adelante se vuele a ocultar)
      $('#LD').show();
      // Oculta el iframe de la pagina WEB Htech
      $('#BRW').hide();
      // Muestra las breadcrums
      document.getElementById("breadC").style.display = "flex";
      // Muestra el canvas de la grafica
      $('#Grafica').show();
      /*-------------------------------------------------------------------------*/
      /*Oculta el input del calendario y reinicia los radio buttons para que este 
      checked el de ultima hora*/
      document.getElementById("spanDate").style.display = "none";
      $("#inlineRadio4").prop('checked', false);
      $("#inlineRadio3").prop('checked', false);
      $("#inlineRadio2").prop('checked', false);
      $("#inlineRadio1").prop('checked', true);
      /*--------------------------------------------------------------------------*/
      /*Obtiene los Sensores disponibles para el grupo seleccionado 
      mediante el id obtenido al inicio del evento click*/ 
      $.post('funcs/idSensores.php', {id}, (response) => {
        /*Obtiene la respuesta y la transforma en formato JSON
         para trabajarla y se asigna a la variable ids*/

        const ids = JSON.parse(response);
        /*--------------------------------------------------*/
        
        // Obtiene el id del Dispositivo que se usa en mqtt
        id_D=ids[0].idDispositivo;
        // console.log(id_D);
        // Verifica si existen 2 o mas sensores en el grupo seleccionado
        NS=ids.length;
        if (NS==2){
          /*Se indica que la Vista por defecto 
          sera la graficacion de la union de los primeros 2 sensores
           con los datos de la ultima hora*/
          id_S = ids[0].idSensor; labelSS[0]= ids[0].tipoSensorTexto; ColorS[0] = ColorBS[ids[0].tipoSensor];
          nameID = ids[1].idSensor; labelSS[1]= ids[1].tipoSensorTexto; ColorS[1] = ColorBS[ids[1].tipoSensor];
          /*De ser asi la variable AUX se asigna con 2 y se agrega a un template 
          el primer item con los 2 primeros sensores para que estos se grafiquen juntos*/
          AUX=2;
          TPS="FULL";
          template = `
                    <li class="nav-item">
                      <a class="nav-link FRSENJoin active" id="${id_S}" name="${nameID}" href="#">${ids[0].tipoSensorTexto}/${ids[1].tipoSensorTexto}</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle DWM" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Sensores</a>
                      <div class="dropdown-menu">
                        <a class="dropdown-item FRSEN" id="${id_S}" name="${ids[0].tipoSensor}" href="#">${ids[0].tipoSensorTexto}</a>
                        <a class="dropdown-item FRSEN" id="${nameID}" name="${ids[1].tipoSensor}" href="#">${ids[1].tipoSensorTexto}</a>
                      </div>
                    </li>
                    `;
          
          DatosLHJ(id_S,nameID);
          // Se activa el mqtt
          MQTT();
          /*----------------------------------------------------------------*/

        } else if(NS==1){
          // En caso Contrario se grafica el unico sensor y se agrega al item
          AUX=0;
          TPS=ids[0].tipoSensorTexto;
          template = `
                    <li class="nav-item">
                      <a class="nav-link FRSEN active" id="${ids[0].idSensor}" name="${ids[0].tipoSensor}" href="#">${ids[0].tipoSensorTexto}</a>
                    </li>           
                    `;
          /*Se llama a la funcion que optiene
          los datos de la ultima hora para el sensor */
          id_S = ids[0].idSensor;
          /*Obtiene el nombre del sensor en caso de que sea solo
        uno se utilizara para el nombre de la serie en la grafica*/
          labelSS[3]= ids[0].tipoSensorTexto;
        /*-------------------------------------------------------*/
          // ColorS[0] = ColorBS[ids[0].tipoSensor];
          TPC=ids[0].tipoSensor;
          DatosLH(id_S);
          MQTT();
          /*-----------------------------------------*/
        }else if (NS==3){
          /*Se indica que la Vista por defecto 
          sera la graficacion de la union de los 3 sensores
           con los datos de la ultima hora*/
           // Presion =>> 1 Flujo =>>2 Nivel =>> 3
          id_S = ids[0].idSensor; labelSS[0]= ids[0].tipoSensorTexto; ColorS[0] = ColorBS[ids[0].tipoSensor];
          nameID = ids[1].idSensor; labelSS[1]= ids[1].tipoSensorTexto; ColorS[1] = ColorBS[ids[1].tipoSensor];
          typeID = ids[2].idSensor; labelSS[2]= ids[2].tipoSensorTexto; ColorS[2] = ColorBS[ids[2].tipoSensor];

          /*De ser asi la variable AUX se asigna con 2 y se agrega a un template 
          el primer item con los 2 primeros sensores para que estos se grafiquen juntos*/
          AUX=3;
          TPS="FULL2";
          template = `
                    <li class="nav-item">
                      <a class="nav-link FRSENJoin active" id="${id_S}" name="${nameID}" type="${typeID}" href="#">${ids[0].tipoSensorTexto}/${ids[1].tipoSensorTexto}/${ids[2].tipoSensorTexto}</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle DWM" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Sensores</a>
                      <div class="dropdown-menu">
                        <a class="dropdown-item FRSEN" id="${id_S}" name="${ids[0].tipoSensor}" href="#">${ids[0].tipoSensorTexto}</a>
                        <a class="dropdown-item FRSEN" id="${nameID}" name="${ids[0].tipoSensor}" href="#">${ids[1].tipoSensorTexto}</a>
                        <a class="dropdown-item FRSEN" id="${typeID}" name="${ids[0].tipoSensor}" href="#">${ids[2].tipoSensorTexto}</a>
                      </div>
                    </li>
                    `;
          
          DatosLHJ2(id_S,nameID,typeID);
          // Se activa el mqtt
          MQTT();
          /*----------------------------------------------------------------*/

        }
        /*---------------------------------------------------------------------------------------------------------*/
        // Finaliza el templateBC con el ultimo elemento activo y el nombre del grupo
          templateBC = templateBC1 + `
                
                    <li class="breadcrumb-item active">${$(this).html()}</li>           
                    ` 
        /*-------------------------------------------------------------------------*/
        /*Inserta los templates mediante los id en su espacio correspondiente en el html
         y le da nombre a la grafica con el nombre del grupo*/
         /*El template tm inserta en el nombre de la grafica el nombre del grupo
         en forma de link a las cordenadas donde se encuentra el dispositivo*/
         let tm = `https://maps.google.com/?q=${ids[0].y},${ids[0].x}&t=h`
          $('#nombrechart').attr("href", tm);
          $('#nombrechart').html($(this).html());
            $('#Sensores').html(template);
            $('#breadC').html(templateBC);
        /*-----------------------------------------------------------------------------*/
        
      });
      /*-----------------------------------------------------------------------------------------------------*/
      // Consulta si el grupo tiene valores de voltaje y corriente 
        $.post('funcs/Bombas.php', {id}, (response) => {
        // verifica si se optuvo respuesta
        if (response != "[]") {
        // si se obtiene respuesta significa que el grupo si tiene valores de voltaje y corriente
        // por lo que los lista en un droplist añadiendolos como item en el template y lo actualiza
        const ids = JSON.parse(response);
             template += `
                    <li class="nav-item">
                      <a class="nav-link VCJoin" id="${ids[0].idGrupo}" href="#">Bomba</a>
                    </li>    
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle DWM1" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Bomba</a>
                    <div class="dropdown-menu">
                        
                      <a class="dropdown-item VL" id="${ids[0].idGrupo}" href="#">Voltaje</a>
                      
                      <a class="dropdown-item CT" id="${ids[0].idGrupo}" href="#">Corriente</a>
                    </div>
                    </li>       
                    `
            // //$('#conteiner').show();
            $('#Sensores').html(template);

          /*----------------------------------------------------------------*/
        }
      });  
      
      /*----------------------------------------------------------------------------------*/
    });
    /*-------------------------------------------------------------------------------------------*/
    /*reinicia lo radio buttons al estado inicial y remueve la clase active 
    del nav tab seleccionado anteriormente y se la asigna al nuevo elemento seleccionado*/
    $('.nav-tabs').on('click', 'a', function(){
        $('.nav-tabs a.active').removeClass('active');
        $(this).addClass('active');
       
        document.getElementById("spanDate").style.display = "none";
        $("#inlineRadio4").prop('checked', false);
        $("#inlineRadio3").prop('checked', false);
        $("#inlineRadio2").prop('checked', false);
        $("#inlineRadio1").prop('checked', true);
    });
    /*--------------------------------------------------------------------------------------*/
    // Captura el evento clik de la lista de sensores para graficarlo
    $(document).on('click', '.FRSEN', function(){
      $(".DWM").addClass('active');
      $('#LD').show();
      TPS = $(this).text();
      TPC = $(this).attr('name');
      // asigna el AUX a 0 para indicar que se graficara solo un sensor
      AUX = 0;
      // obtiene el id del sensor a graficar
      id_S = $(this).attr('id');
      // asigan el nombre del sensor a labelS para darle nombre a la serie en la grafica
      labelSS[3] = $(this).text();
      /*Se llama a la funcion que optiene
          los datos de la ultima hora para el sensor seleccionado */
      DatosLH(id_S);
    });
    /*-------------------------------------------------------------------------------------*/
    // Captura el evento clik del item que indica graficar los 2 sensores juntos
    $(document).on('click', '.FRSENJoin', function(){
      $('#LD').show();
      
      if(NS==2){
        TPS = "FULL";
        // asigna el AUX a 2 para indicar que se graficaran los dos sensores juntos
        AUX = 2;
        // obtiene el id de los sensores a graficar, nota: el id del segundo sensor agraficar se obtiene 
        // del atributo name (este es asignado anteriormente al atributo al crear el template)
        id_S = $(this).attr('id');
        nameID = $(this).attr('name');
        /*Se llama a la funcion que optiene
            los datos de la ultima hora para los sensores */
        DatosLHJ(id_S,nameID);
      }else{
        TPS = "FULL2";
        // asigna el AUX a 3 para indicar que se graficaran los 3 sensores juntos
        AUX = 3;
        // obtiene el id de los sensores a graficar, nota: el id del segundo sensor agraficar se obtiene 
        // del atributo name (este es asignado anteriormente al atributo al crear el template)
        id_S = $(this).attr('id');
        nameID = $(this).attr('name');
        typeID = $(this).attr('type');
        /*Se llama a la funcion que optiene
            los datos de la ultima hora para los sensores */
        DatosLHJ2(id_S,nameID,typeID);
      }
      
    });
    /*-------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------*/
    // Captura el evento clik de la lista de bombas para graficarlas
    $(document).on('click', '.VL', function(){
      $('#LD').show();
      TPS = "VL";
      $(".DWM1").addClass('active');
      // asigna el AUX a  para indicar que se graficaran voltajes o corrientes
      AUX = 1;
      // asigna el TP a 0 para indicar que se graficaran voltajes
      TP = 0;
      // obtiene el id del grupo al que pertenecen los voltajes
      id_S = $(this).attr('id');
      /*Se llama a la funcion que optiene
          los datos de la ultima hora para los voltajes pertenecientes al grupo seleccionado */
      DatosLHIV(id_S,TP);
    });
    /*-------------------------------------------------------------------------------------*/
    // Captura el evento clik de la lista de bombas para graficarlas
    $(document).on('click', '.CT', function(){
      $('#LD').show();
      TPS = "CT";
      $(".DWM1").addClass('active');
      // asigna el AUX a  para indicar que se graficaran voltajes o corrientes
      AUX = 1;
      // asigna el TP a 0 para indicar que se graficaran corrientes
      TP = 1;
      // obtiene el id del grupo al que pertenecen las corrientes
      id_S = $(this).attr('id');
      /*Se llama a la funcion que optiene
          los datos de la ultima hora para las corrientes pertenecientes al grupo seleccionado */
      DatosLHIV(id_S,TP);
    });
    /*-------------------------------------------------------------------------------------*/
    // Captura el evento clik a la bomba para graficarlas
    $(document).on('click', '.VCJoin', function(){
      $('#LD').show();
      TPS = "VC";
      TP = 2; 
      // asigna el AUX a  para indicar que se graficaran voltajes o corrientes
      AUX = 1;
      // obtiene el id del grupo
      id_S = $(this).attr('id');
      /*Se llama a la funcion que optiene
          los datos de la ultima hora para los voltajes pertenecientes al grupo seleccionado */
      DatosLHIV(id_S);
    });
    /*-------------------------------------------------------------------------------------*/
    
    
    // Se Captura el evento change de los radio buttons
    $('input[name=inlineRadioOptions]').on('change', function() {
      // verifica que radio button esta seleccionado o cheked
        if ($(this).val() == "option1") {
            // si el radio button 1 (option1) perteneciente a la ultima hora
            // pone invisible el input del calendario
            document.getElementById("spanDate").style.display = "none";
            /*Segun sea el valor del axiliar manda a llamar a la 
            funcion correspondiente que grafica la ultima hora*/
            $('#LD').show();
            switch (AUX) {
              case 0:
                DatosLH(id_S);
                break;
              case 1:
                DatosLHIV(id_S,TP);
                break;
              case 2:
                DatosLHJ(id_S,nameID);
                break;
              case 3:
                DatosLHJ2(id_S,nameID,typeID);
                break;
            }
            /*----------------------------------------------------------------*/
        } else if($(this).val() == "option3") {
          document.getElementById("spanDate").style.display = "none";
          $('#LD').show();
            const startdate = moment().format('YYYYMMDD')+"000000";
            const enddate = moment().format('YYYYMMDD')+"235959";
            switch (AUX) {
              case 0:
                fetchData(id_S,startdate,enddate);
                break;
              case 1:
                fetchDataIV(id_S,startdate,enddate,TP);
                break;
              case 2:
                fetchDataJ(id_S,nameID,startdate,enddate);
                break;
              case 3:
                fetchDataJ2(id_S,nameID,typeID,startdate,enddate);
                break;
            }


        } else if($(this).val() == "option4") {
          document.getElementById("spanDate").style.display = "none";
          $('#LD').show();
            const startdate = moment().subtract(1, 'days').format('YYYYMMDD')+"000000";
            const enddate = moment().subtract(1, 'days').format('YYYYMMDD')+"235959";
            switch (AUX) {
              case 0:
                fetchData(id_S,startdate,enddate);
                break;
              case 1:
                fetchDataIV(id_S,startdate,enddate,TP);
                break;
              case 2:
                fetchDataJ(id_S,nameID,startdate,enddate);
                break;
              case 3:
                fetchDataJ2(id_S,nameID,typeID,startdate,enddate);
                break;
            }


        }else {
            /*De no ser la option1, significa que esta seleccionado el radiobutton 2 
            perteneciente a la opcion personalizada
            por lo que se manda llamar la funcion del calentario*/
            DatePK();
            /*---------------------------------------------------------------------*/
            // Se hace visible el input del calendario
            document.getElementById("spanDate").style.display = "block";
            /*-----------------------------------------------------------*/
        }
      /*-------------------------------------------------------------------------------------*/
    });
   /*-------------------------------------------------------------------------------------*/

    // Funcion para obtener los datos en un rango de fechas de un solo sensor
    function fetchData(id_S,fi,ff){
        $.post('funcs/fetchDatos.php', {id_S,fi,ff}, (response) => {
        // Se manda llamar la funcion que extrae los datos para graficarlos
        ExtD(response);
        /*----------------------------------------------------------*/
      });
    }
    /*-----------------------------------------------------------------*/
    // Funcion para obtener los datos de la ultima hora de un solo sensor
    function DatosLH(id_S){
        $.post('funcs/fetchDatosLH.php', {id_S}, (response) => {
          ExtD(response);
        });
    }
    /*-----------------------------------------------------------------*/
    // Funcion para obtener los datos en un rango de fechas de las tensiones de un grupo
    function fetchDataIV(id,fi,ff,TP){
        $.post('funcs/fetchDatosIV.php', {id,fi,ff}, (response) => {
        // Se manda llamar la funcion que extrae los datos para graficarlos
        ExtDIV(response,TP);
        /*---------------------------------------------------------------*/
      });
    }
    /*-----------------------------------------------------------------*/
    // Funcion para obtener los datos de la ultima hora de las tensiones de un grupo
    function DatosLHIV(id,TP){
        $.post('funcs/fetchDatosLHIV.php', {id}, (response) => {
          ExtDIV(response,TP);
        });
    }
    /*-----------------------------------------------------------------*/
    // Funcion para obtener los datos en un rango de fechas de los 2 sensores
    function fetchDataJ(id_S,nameID,fi,ff){
        // consulta de datos del primer sensor
        $.post('funcs/fetchDatos.php', {id_S,fi,ff}, (response) => {
          // Se manda llamar la funcion que extrae los datos para graficarlos
          JoinD(response,0);
          // consulta de datos del segundo sensor
          $.post('funcs/fetchDatosJ.php', {nameID,fi,ff}, (response) => {
          JoinD(response,1);
        });
        });
    }
    /*-----------------------------------------------------------------*/
    // Funcion para obtener los datos de la ultima hora de de los 2 sensores
    function DatosLHJ(id_S,nameID){
        $.post('funcs/fetchDatosLH.php', {id_S}, (response) => {
          JoinD(response,0);
          $.post('funcs/fetchDatosLHJ.php', {nameID}, (response) => {
          JoinD(response,1);
          });
        });
    }
    /*-----------------------------------------------------------------*/

    /*Funcion que extrae los datos de los 2 sensores para graficarlos juntos*/
    function JoinD(datos,i){
      /*la variable i ayuda a saber que llamada se esta ejecutando.*/
      switch (i) {
      /*Para el primer sensor el valor de i es 0 y solo se guardan los datos del mismo.*/
        case 0:
          datos1 = datos;
          break;
        // Para la segunda llamada i es 1
        case 1:
        /* Se extraen las fechas*/
          var fecha = jmespath.search(JSON.parse(datos), "[::-1] | [*].fecha");
          CC =fecha.length;
          // se extraen los datos del primer sensor.
          var datosS = jmespath.search(JSON.parse(datos1), "[::-1] | [*].dato");
          // se extraen los datos del segundo sensor.
          var datosS2 = jmespath.search(JSON.parse(datos), "[::-1] | [*].dato");
          // se manda llamar la funcion donde se crea la grafica con estos datos
          ChartData2(fecha,datosS,datosS2);
          break;
      }
    }
    /*-----------------------------------------------------------------*/
    // Funcion para obtener los datos de la ultima hora de de los 3 sensores
    function DatosLHJ2(id_S,nameID,typeID){
        $.post('funcs/fetchDatosLH.php', {id_S}, (response) => {
          JoinD2(response,0);
          $.post('funcs/fetchDatosLHJ.php', {nameID}, (response) => {
          JoinD2(response,1);
          $.post('funcs/fetchDatosLHJ2.php', {typeID}, (response) => {
          JoinD2(response,2);
          });
          });
        });
    }
    /*-----------------------------------------------------------------*/
    // Funcion para obtener los datos en un rango de fechas de los 3 sensores
    function fetchDataJ2(id_S,nameID,typeID,fi,ff){
        // consulta de datos del primer sensor
        $.post('funcs/fetchDatos.php', {id_S,fi,ff}, (response) => {
          // Se manda llamar la funcion que extrae los datos para graficarlos
          JoinD2(response,0);
          // consulta de datos del segundo sensor
          $.post('funcs/fetchDatosJ.php', {nameID,fi,ff}, (response) => {
            JoinD2(response,1);
            // consulta de datos del segundo sensor
            $.post('funcs/fetchDatosJ2.php', {typeID,fi,ff}, (response) => {
              // consulta de datos del tercer sensor
              JoinD2(response,2);
            });
          });
        });
    }
    /*-----------------------------------------------------------------*/

    /*Funcion que extrae los datos de los 2 sensores para graficarlos juntos*/
    function JoinD2(datos,i){
      /*la variable i ayuda a saber que llamada se esta ejecutando.*/
      switch (i) {
      /*Para el primer sensor el valor de i es 0 y solo se guardan los datos del mismo.*/
        case 0:
          datos1 = datos;
          break;
        case 1:
          datos2 = datos;
          break;
        // Para la segunda llamada i es 1
        case 2:
        /* Se extraen las fechas*/
          var fecha = jmespath.search(JSON.parse(datos), "[::-1] | [*].fecha");
          CC =fecha.length;
          // se extraen los datos del primer sensor.
          var datosS = jmespath.search(JSON.parse(datos1), "[::-1] | [*].dato");
          // se extraen los datos del primer sensor.
          var datosS2 = jmespath.search(JSON.parse(datos2), "[::-1] | [*].dato");
          // se extraen los datos del segundo sensor.
          var datosS3 = jmespath.search(JSON.parse(datos), "[::-1] | [*].dato");
          // se manda llamar la funcion donde se crea la grafica con estos datos
          ChartData3(fecha,datosS,datosS2,datosS3);
          break;
      }
    }
    /*-----------------------------------------------------------------*/
    /*Funcion que extrae los datos para un solo sensor*/
    function ExtD(datos){
        //Se Extrae la fecha
         var fecha = jmespath.search(JSON.parse(datos), "[::-1] | [*].fecha");
         //Se Extrae los datos
         var datosS = jmespath.search(JSON.parse(datos), "[::-1] | [*].dato");
         // Se manda llamar la funcion que los grafica
        CC =fecha.length;
        ChartData(fecha,datosS);
    }
    /*-----------------------------------------------------------------*/
    /*Funcion que extrae los datos de los voltajes y corrientes*/
    function ExtDIV(datos,TP){
        // Se extraen las fechas
         var fecha = jmespath.search(JSON.parse(datos), "[::-1] | [*].fecha");
         CC =fecha.length;
         // Dato el valor de TP se decide si se grafica voltajes o corrientes
         if (TP==0) {
          // Se extraen los datos de los voltajes
          var VL1 = jmespath.search(JSON.parse(datos), "[::-1] | [*].voltaje1");
          var VL2 = jmespath.search(JSON.parse(datos), "[::-1] | [*].voltaje2");
          var VL3 = jmespath.search(JSON.parse(datos), "[::-1] | [*].voltaje3");
          // se asigna los nombre para las series de la grafica
          const labelIV =["Voltaje1","Voltaje2","Voltaje3"];
          // se asigna el color para las series
          const colorBK=['rgba(243, 232, 127, 1)','rgba(243, 124, 128, 1)','rgba(159, 124, 252, 1)'];
          // se manda llamar la funcion que construye la grafica en el canvas con los datos
          ChartData3IV(fecha,VL1,VL2,VL3,labelIV,colorBK);
         } else if (TP==1) {
          // se realiza el mismo procedimiento que para el voltaje
          var CT1 = jmespath.search(JSON.parse(datos), "[::-1] | [*].corriente1");
          var CT2 = jmespath.search(JSON.parse(datos), "[::-1] | [*].corriente2");
          var CT3 = jmespath.search(JSON.parse(datos), "[::-1] | [*].corriente3");
          const labelIV =["Corriente1","Corriente2","Corriente3"];
          const colorBK=['rgba(210, 124, 251, 1)','rgba(90, 154, 251, 1)','rgba(120, 153, 158, 1)'];
          ChartData3IV(fecha,CT1,CT2,CT3,labelIV,colorBK);
         } else {
          var VL1 = jmespath.search(JSON.parse(datos), "[::-1] | [*].voltaje1");
          var VL2 = jmespath.search(JSON.parse(datos), "[::-1] | [*].voltaje2");
          var VL3 = jmespath.search(JSON.parse(datos), "[::-1] | [*].voltaje3");
          var CT1 = jmespath.search(JSON.parse(datos), "[::-1] | [*].corriente1");
          var CT2 = jmespath.search(JSON.parse(datos), "[::-1] | [*].corriente2");
          var CT3 = jmespath.search(JSON.parse(datos), "[::-1] | [*].corriente3");
          const labelIV =["Voltaje1","Voltaje2","Voltaje3","Corriente1","Corriente2","Corriente3"];
          const colorBK=['rgba(243, 232, 127, 1)','rgba(243, 124, 128, 1)','rgba(159, 124, 252, 1)','rgba(210, 124, 251, 1)','rgba(90, 154, 251, 1)','rgba(120, 153, 158, 1)'];
          ChartData6(fecha,VL1,VL2,VL3,CT1,CT2,CT3,labelIV,colorBK);
         }
    }
    /*-----------------------------------------------------------------*/
    
    // Funcion que grafica los datos de voltajes o corrientes
    function ChartData6(datesresult,points,points2,points3,points4,points5,points6,labelIV,colorBK){
      // asigna los datos que fungiran como labels para el eje x (fechas)

        $('#LD').hide();
        const dates = datesresult;
        // se asignan los datos para generar los puntos en la grafica para cada serie
        const datapoints = points;
        const datapoints2 = points2;
        const datapoints3 = points3;
        const datapoints4 = points4;
        const datapoints5 = points5;
        const datapoints6 = points6;
        // se configura las series a graficar
        const data = {
          // se asignan las labels eje x
          labels: dates,
          datasets: [{
            // se configura la etiqueta de la serie
            label: labelIV[0],
            // los puntos para contruir la serie eje y
            data: datapoints,
            // el color de fondo de la serie
            backgroundColor:colorBK[0],
            // el color del borde de la serie
            borderColor:colorBK[0],
            // el ancho de la serie
            borderWidth: 1
          },
          {
            label: labelIV[1],
            data: datapoints2,
            backgroundColor:colorBK[1],
            borderColor:colorBK[1],
            borderWidth: 1
          },
          {
            label: labelIV[2],
            data: datapoints3,
            backgroundColor:colorBK[2],
            borderColor:colorBK[2],
            borderWidth: 1
          },
          {
           
            label: labelIV[3],
            data: datapoints4,
            backgroundColor:colorBK[3],
            borderColor:colorBK[3],
            borderWidth: 1
          },
          {
            label: labelIV[4],
            data: datapoints5,
            backgroundColor:colorBK[4],
            borderColor:colorBK[4],
            borderWidth: 1
          },
          {
            label: labelIV[5],
            data: datapoints6,
            backgroundColor:colorBK[5],
            borderColor:colorBK[5],
            borderWidth: 1
          }
          ]
        };
        // se configuran las funcionalidades de la grafica -vease la api CHARTJS
        // config 
        const config = {
          type: 'line',
          data,
          options: {
            plugins: {
            zoom: {
              zoom: {
                wheel: {
                  enabled: true,
                  modifierKey: 'ctrl'
                },
                pinch: {
                  enabled: true
                },
                mode: 'xy',
              },
              pan: {
                  enabled: true,
                  mode: 'xy',
                  modifierKey: 'ctrl'
                }
            }
          },
            scales: {
              x: {
                ticks: {
                  // For a category axis, the val is the index so the lookup via getLabelForValue is needed
                  callback: function(val, index) {
                    // Hide every 2nd tick label
                    if(CC<10){
                      return index % 1 === 0 ? (this.getLabelForValue(val)).slice(11,-3) : '';

                    }else if(CC<100){

                      return index % 2 === 0 ? (this.getLabelForValue(val)).slice(11,-3) : '';
                    }else{
                     return index % 3 === 0 ? moment((this.getLabelForValue(val)).slice(0,11), "YYYY-MM-DD").format("MMM Do") : '';
                    }
                  },
                  color: "blue",
                }
              },
              y: {
                beginAtZero: false
              }
            }
          }
        };
        // Se destruye la grafica anterior de existir alguna
        if (myChart) {
        myChart.destroy();
        }
        // render init block
        myChart = new Chart(
          document.getElementById('myChart'),
          config
        );
    }
    // Funcion que grafica los datos de voltajes o corrientes
   function ChartData3IV(datesresult,points,points2,points3,labelIV,colorBK){
    // asigna los datos que fungiran como labels para el eje x (fechas)
      $('#LD').hide();
      const dates = datesresult;
      // se asignan los datos para generar los puntos en la grafica para cada serie
      const datapoints = points;
      const datapoints2 = points2;
      const datapoints3 = points3;
      // se configura las series a graficar
      const data = {
        // se asignan las labels eje x
        labels: dates,
        datasets: [{
          // se configura la etiqueta de la serie
          label: labelIV[0],
          // los puntos para contruir la serie eje y
          data: datapoints,
          // el color de fondo de la serie
          backgroundColor:colorBK[0],
          // el color del borde de la serie
          borderColor:colorBK[0],
          // el ancho de la serie
          borderWidth: 1
        },
        {
          label: labelIV[1],
          data: datapoints2,
          backgroundColor:colorBK[1],
          borderColor:colorBK[1],
          borderWidth: 1
        },
        {
          label: labelIV[2],
          data: datapoints3,
          backgroundColor:colorBK[2],
          borderColor:colorBK[2],
          borderWidth: 1
        }
        ]
      };
      // se configuran las funcionalidades de la grafica -vease la api CHARTJS
      // config 
      const config = {
        type: 'line',
        data,
        options: {
          plugins: {
          zoom: {
            zoom: {
              wheel: {
                enabled: true,
                modifierKey: 'ctrl'
              },
              pinch: {
                enabled: true
              },
              mode: 'xy',
            },
            pan: {
                enabled: true,
                mode: 'xy',
                modifierKey: 'ctrl'
              }
          }
        },
          scales: {
            x: {
              ticks: {
                // For a category axis, the val is the index so the lookup via getLabelForValue is needed
                callback: function(val, index) {
                  // Hide every 2nd tick label
                  if(CC<10){
                    return index % 1 === 0 ? (this.getLabelForValue(val)).slice(11,-3) : '';

                  }else if(CC<100){

                    return index % 2 === 0 ? (this.getLabelForValue(val)).slice(11,-3) : '';
                  }else{
                   return index % 3 === 0 ? moment((this.getLabelForValue(val)).slice(0,11), "YYYY-MM-DD").format("MMM Do") : '';
                  }
                },
                color: "blue",
              }
            },
            y: {
              beginAtZero: false
            }
          }
        }
      };
      // Se destruye la grafica anterior de existir alguna
      if (myChart) {
      myChart.destroy();
      }
      // render init block
      myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
  }
    // funcion para graficar los datos de 3 sensores en la misma grafica
    function ChartData3(datesresult,points,points2,points3){
      $('#LD').hide();
        const dates = datesresult;
        const datapoints = points;
        const datapoints2 = points2;
        const datapoints3 = points3;
        

        const data = {
          labels: dates,
          datasets: [{
            label: labelSS[0],
            data: datapoints,
            backgroundColor:ColorS[0],
            borderColor:ColorS[0],
            borderWidth: 1
          },
          {
            label: labelSS[1],
            data: datapoints2,
            backgroundColor:ColorS[1],
            borderColor:ColorS[1],
            borderWidth: 1
          },
          {
            label: labelSS[2],
            data: datapoints3,
            backgroundColor:ColorS[2],
            borderColor:ColorS[2],
            borderWidth: 1
          }
          ]
        };

     // config 
        const config = {
          type: 'line',
          data,
          options: {
            plugins: {
            zoom: {
              zoom: {
                wheel: {
                  enabled: true,
                  modifierKey: 'ctrl'
                },
                pinch: {
                  enabled: true
                },
                mode: 'xy',
              },
              pan: {
                  enabled: true,
                  mode: 'xy',
                  modifierKey: 'ctrl'
                }
            }
          },
            scales: {
              x: {
                ticks: {
                  // For a category axis, the val is the index so the lookup via getLabelForValue is needed
                  callback: function(val, index) {
                    // Hide every 2nd tick label
                    if(CC<10){
                      return index % 1 === 0 ? (this.getLabelForValue(val)).slice(11,-3) : '';

                    }else if(CC<100){

                      return index % 2 === 0 ? (this.getLabelForValue(val)).slice(11,-3) : '';
                    }else{
                     return index % 3 === 0 ? moment((this.getLabelForValue(val)).slice(0,11), "YYYY-MM-DD").format("MMM Do") : '';
                    }  
                  },
                  color: 'blue',
                }
              },
              y: {
                beginAtZero: false
              }
            }
          }
        };

        if (myChart) {
        myChart.destroy();
        }
        // render init block
        myChart = new Chart(
          document.getElementById('myChart'),
          config
        );
    }
    // funcion para graficar los datos de 2 sensores en la misma grafica
    function ChartData2(datesresult,points,points2){
      $('#LD').hide();
        const dates = datesresult;
        const datapoints = points;
        const datapoints2 = points2;
        

        const data = {
          labels: dates,
          datasets: [{
            label: labelSS[0],
            data: datapoints,
            backgroundColor:ColorS[0],
            borderColor:ColorS[0],
            borderWidth: 1
          },
          {
            label: labelSS[1],
            data: datapoints2,
            backgroundColor:ColorS[1],
            borderColor:ColorS[1],
            borderWidth: 1
          }
          ]
        };

     // config 
        const config = {
          type: 'line',
          data,
          options: {
            plugins: {
            zoom: {
              zoom: {
                wheel: {
                  enabled: true,
                  modifierKey: 'ctrl'
                },
                pinch: {
                  enabled: true
                },
                mode: 'xy',
              },
              pan: {
                  enabled: true,
                  mode: 'xy',
                  modifierKey: 'ctrl'
                }
            }
          },
            scales: {
              x: {
                ticks: {
                  // For a category axis, the val is the index so the lookup via getLabelForValue is needed
                  callback: function(val, index) {
                    // Hide every 2nd tick label
                    if(CC<10){
                      return index % 1 === 0 ? (this.getLabelForValue(val)).slice(11,-3) : '';

                    }else if(CC<100){

                      return index % 2 === 0 ? (this.getLabelForValue(val)).slice(11,-3) : '';
                    }else{
                     return index % 3 === 0 ? moment((this.getLabelForValue(val)).slice(0,11), "YYYY-MM-DD").format("MMM Do") : '';
                    }  
                  },
                  color: 'blue',
                }
              },
              y: {
                beginAtZero: false
              }
            }
          }
        };

        if (myChart) {
        myChart.destroy();
        }
        // render init block
        myChart = new Chart(
          document.getElementById('myChart'),
          config
        );
    }
    // Funcion que grfica los datos de un solo sensor
    function ChartData(datesresult,points){
      $('#LD').hide();
        const dates = datesresult;
        const datapoints = points;
        const data = {
          labels: dates,
          datasets: [{
            label: labelSS[3],
            data: datapoints,
            backgroundColor:ColorBS[TPC],
            borderColor:ColorBS[TPC],
            borderWidth: 1
          }
          ]
        };

        // config 
        const config = {
          type: 'line',
          data,
          options: {
            plugins: {
            zoom: {
              zoom: {
                wheel: {
                  enabled: true,
                  modifierKey: 'ctrl'
                },
                pinch: {
                  enabled: true
                },
                mode: 'xy',
              },
              pan: {
                  enabled: true,
                  mode: 'xy',
                  modifierKey: 'ctrl'
                }
            }
          },
            scales: {
              x: {
                ticks: {
                  // For a category axis, the val is the index so the lookup via getLabelForValue is needed
                  callback: function(val, index) {
                    // Hide every 2nd tick label
                    if(CC<10){
                      return index % 1 === 0 ? (this.getLabelForValue(val)).slice(11,-3) : '';

                    }else if(CC<100){

                      return index % 2 === 0 ? (this.getLabelForValue(val)).slice(11,-3) : '';
                    }else{
                     return index % 3 === 0 ? moment((this.getLabelForValue(val)).slice(0,11), "YYYY-MM-DD").format("MMM Do") : '';
                    }
                  },
                  color: 'blue',
                }
              },
              y: {
                beginAtZero: false
              }
            }
          }
        };

        if (myChart) {
        myChart.destroy();
        }
        // render init block
        myChart = new Chart(
          document.getElementById('myChart'),
          config
        );
    }
    // Funcion que genera el calendario y mantiene la funcionalidad para este -consultar el api daterangepicker
    function DatePK(){
      $('#daterange').daterangepicker({
        "showDropdowns": true,
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Última Semana': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
            'Este Mes': [moment().startOf('month'), moment().endOf('month')],
            'Mes Anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Apply",
            "cancelLabel": "Cancel",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Personalizado",
            "weekLabel": "W",
            "daysOfWeek": [
                "D",
                "L",
                "M",
                "M",
                "J",
                "V",
                "S"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 1
        },
        "parentEl": "DashHTECH",
        "startDate": moment(),
        "endDate": moment(),
        "minDate": "12/12/2000",
        "maxDate": "12/12/2222",
        "linkedCalendars": false,
        "cancelClass": "btn-danger",
        "opens": "left",
        "drops": "up"
    }, function(start, end, label) {
      // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        // Formatea la fecha al formato desado
        const startdate = start.format('YYYYMMDD')+"000000";
        const enddate = end.format('YYYYMMDD')+"235959";
       /*Segun sea el valor de AUX manda a llamar a la 
            funcion correspondiente que obtiene los datos*/
        
        switch (AUX) {
          case 0:
            $('#LD').show();
            fetchData(id_S,startdate,enddate);
            break;
          case 1:
            $('#LD').show();
            fetchDataIV(id_S,startdate,enddate,TP);
            break;
          
          case 2:
            $('#LD').show();
            fetchDataJ(id_S,nameID,startdate,enddate);
            break;

          case 3:
            $('#LD').show();
            fetchDataJ2(id_S,nameID,typeID,startdate,enddate);
            break;
        }
        /*-----------------------------------------------------------------*/
    });
    /*-------------------------------------------------------------------------------------------------*/
    }    
    /*-------------------------------------------------------------------------------------------------------------*/ 
    function MQTT(){
      const clientIdvalue = "DS"+Math.random();
      const options = {
         //Clean session
        clean: true,
        connectTimeout: 4000,
        // Auth
        clientId: clientIdvalue,
        username: 'oscar',
        password: 'Oscar12*',
      }
      const client  = mqtt.connect('wss://4d9883bec29847b4880e91d92a345abd.s1.eu.hivemq.cloud:8884/mqtt',options)

      function EventoConectar(){
        const topic="/sensores/"+id_D+"/web";
        // console.log(topic);
        client.subscribe(topic,function(err){
          // if (!err) {
          //   // client.publish('/sensores', 'Hi me comunico desde JS')

          // }
        })
      }
      function EventoMensaje(topic, message){
          console.log("Mensaje ==> "+ message.toString());
          ms = JSON.parse(message.slice(11,));
          // console.log(ms.ID);
          // console.log(id_D);

          if (ms.Tipo=="Dato") {
            const FS = moment(ms.Fecha).format("YYYY-MM-DD")+" "+moment(ms.Hora,"hh:mm:ss").format("h:mm:ss");
            switch (TPS) {
              case "FULL":
                myChart.config.data.labels.push(FS);
                myChart.config.data.datasets[0].data.push(ms.P);
                myChart.config.data.datasets[1].data.push(ms.F);
                myChart.update();
                break;
              case "Presión":
                myChart.config.data.labels.push(FS);
                myChart.config.data.datasets[0].data.push(ms.P);
                myChart.update();
                break;
              
              case "Flujo":
                myChart.config.data.labels.push(FS);
                myChart.config.data.datasets[0].data.push(ms.F);
                myChart.update();
                break;
              case "Nivel":
                myChart.config.data.labels.push(FS);
                myChart.config.data.datasets[0].data.push(ms.N);
                myChart.update();
                break;
              case "VL":
                myChart.config.data.labels.push(FS);
                myChart.config.data.datasets[0].data.push(ms.V1);
                myChart.config.data.datasets[1].data.push(ms.V2);
                myChart.config.data.datasets[2].data.push(ms.V3);
                myChart.update();
                break;
              case "CT":
                myChart.config.data.labels.push(FS);
                myChart.config.data.datasets[0].data.push(ms.C1);
                myChart.config.data.datasets[1].data.push(ms.C2);
                myChart.config.data.datasets[2].data.push(ms.C3);
                myChart.update();
                break;
              case "VC":
                myChart.config.data.labels.push(FS);
                myChart.config.data.datasets[0].data.push(ms.V1);
                myChart.config.data.datasets[1].data.push(ms.V2);
                myChart.config.data.datasets[2].data.push(ms.V3);
                myChart.config.data.datasets[3].data.push(ms.C1);
                myChart.config.data.datasets[4].data.push(ms.C2);
                myChart.config.data.datasets[5].data.push(ms.C3);
                myChart.update();
                break;
              case "FULL2":
                myChart.config.data.labels.push(FS);
                myChart.config.data.datasets[0].data.push(ms.P);
                myChart.config.data.datasets[1].data.push(ms.F);
                myChart.config.data.datasets[2].data.push(ms.N);
                myChart.update();
                break;
            }


          }
          

          
        
        // console.log(topic + " - " + message.toString());
      }

      client.on('connect',EventoConectar);
      client.on('message',EventoMensaje);
  }
  function myFunction() {
    $('#LD').hide();
  }
  function deshabilitaRetroceso(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="no-back-button";}
  }

  function ismovil(){
    if( navigator.userAgent.match(/Android/i)
      || navigator.userAgent.match(/webOS/i) 
      || navigator.userAgent.match(/iPhone/i)
      || navigator.userAgent.match(/iPad/i)
      || navigator.userAgent.match(/iPod/i)
      || navigator.userAgent.match(/BlackBerry/i)
      || navigator.userAgent.match(/Windows Phone/i)){

      $('#BRW').removeClass('embed-responsive');
      $('#BRW').addClass('panorama');
      
      $('.blanco').addClass('small');
      $('#myChart').attr("height",'100%');
      movil=1;

    }
  }


});