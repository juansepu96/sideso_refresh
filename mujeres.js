var promesas = [];

function CargarEnTabla(rta){
    $(".filaPersonas").remove();
    if(rta.length>0){
        rta.map((e)=>{
                id=e.ID;
                dni=e.DNI;
                fecha = moment(e.date);
                fecha = fecha.format("DD/MM/YYYY");
                var htmlTags = '<tr class="filaPersonas" >' +
                    '<td onclick="AbrirPersona('+id+');">' + e['DNI'] + '</td>' +
                    '<td onclick="AbrirPersona('+id+');" >' + e['nombre'] + '</td>'+
                    '<td onclick="AbrirPersona('+id+');">' + fecha + '</td>';
                    var a = (id) =>{
                        $.post("./php/VerificarUltIntervencion.php",{valorBusqueda:id})
                        .then((date)=>{
                            htmlTags=htmlTags+'<td>'+date+'</td>';
                        });
                        }
                    var b = (dni) => {
                        $.when( a(id) ).done(()=>{
                            $.post("./php/VerificarEncuesta.php",{valorBusqueda:e.DNI})
                            .then((result)=>{
                                if(result=="SI"){
                                    htmlTags=htmlTags+'<td style="color:green; font-weight: bold;" onclick="AbrirFichaSocial('+dni+');">SI</td></tr>';
                                }else{
                                    htmlTags=htmlTags+'<td style="color:red; font-weight: bold;">NO</td></tr>';
                                }
                                $('#tabla-personas tbody').append(htmlTags);
                               });
                        })
                    }
                    b(dni);
                    

        })
    }
}


function CargarPersonas(){
    $.post("./php/CargarPersonasMujeres.php")
    .then((rta)=>{
        rta=JSON.parse(rta);
        CargarEnTabla(rta);
    })
}

function BuscarPersonas(){
    dato=$("#buscar").val();
    $.post("./php/BuscarPersonas.php",{valorBusqueda:dato})
    .then((rta)=>{
        rta=JSON.parse(rta);
        CargarEnTabla(rta);
    })
}

function AbrirPersona(id=null){
    $("#formVerFicha")[0].reset();
    $(".filaIntervenciones").remove();
    if(id){
        $("#menu-2").prop('hidden',false);
        $("#actualizar").prop('hidden',false);
        $("#guardar_persona").prop('hidden',true);
        $.post("./php/ObtenerDatosPersona.php",{valorBusqueda:id})
        .then((rta)=>{
            rta=JSON.parse(rta);
            rta.forEach((e)=>{
                $("#id_persona").val(e.ID);
                $("#dni_persona").val(e.DNI);
                $("#dni").val(e.DNI);
                $("#nombre").val(e.nombre);
                $("#fecha_nacimiento").val(e.date);
                $("#domicilio").val(e.domicilio);
                $("#telefono").val(e.telefono);
                $("#texto_observaciones").val(e.obs);
            })
            ObtenerIntervenciones(id);
            CargarDocumentos(id);
        })
    }else{
        $("#observaciones").prop('hidden',true);
        $("#dni").prop("readonly",false);
        $("#actualizar").prop('hidden',true);
        $("#guardar_persona").prop('hidden',false);
        $("#menu-2").prop('hidden',true);
    } 
    $('#VerFicha').modal('show');
}

function ObtenerIntervenciones(id){
    $.post("./php/ObtenerIntervenciones.php",{valorBusqueda:id})
    .then((response)=>{
        response=JSON.parse(response);
        response.forEach((el)=>{
            fecha = moment(el.fecha);
            fecha = fecha.format("DD/MM/YYYY");
            var htmlTags = '<tr class="filaIntervenciones" >' +
            '<td>' + fecha + '</td>' +
            '<td>' + el.detalle + '</td>'+
            '<td>' + el.intervino + '</td></tr>';
            $('#tabla-intervenciones tbody').append(htmlTags);
        })
    })
}

function NuevaIntervencion(){
    fecha = moment();
    fecha = fecha.format("YYYY-MM-DD");
    $("#fecha_inter").val(fecha);
    $('#NuevaIntervencion').modal('show');

}

function CerrarIntertenvencion (){
    $('#NuevaIntervencion').modal('hide');
}

function CargarIntervencion(){
    id=$("#id_persona").val();
    datos=[];
    fecha=$("#fecha_inter").val();
    detalle=$("#detalle_inter").val();
    datos.push(fecha,detalle,id);
    datos=JSON.stringify(datos);
    $.post("./php/NuevaIntervencion.php",{valorBusqueda:datos})
    .then(()=>{
        cuteToast({
            type: "success", // or 'info', 'error', 'warning'
            message: "Intervencion cargada con éxito!",
            timer: 3000
          })
          $("#fecha_inter").val("");
          $("#detalle_inter").val("");
        CerrarIntertenvencion();
        $('#VerFicha').modal('hide');
        AbrirPersona(id);
    })
    
}

function CargarDocumentos(id){
    $(".filaDocumentos").remove();
    $.post("./php/ObtenerDocumentos.php",{valorBusqueda:id})
    .then((rta)=>{
        if(rta){
            rta=JSON.parse(rta);
            rta.forEach((e)=>{
                var htmlTags = '<tr class="filaDocumentos" >' +
                    '<td>' + e.detalle + '</td>' +
                    '<td>' + e.url + '</td>'+
                    '<td>' + `<button type="button" class="b-0 p-1 btn btn-primary" onclick="AbrirDocumento('`+e.url+`')"> <i class="far fa-folder-open fa-2x"></i> </button>` + '</td>'+
                    '<td>' + `<button type="button" class="b-0 p-1 btn btn-primary bg-danger" onclick="EliminarDocumento('`+e.ID+`')"> <i class="far fa-trash-alt fa-2x"></i>  </button>` + '</td></tr>';
                    $('#tabla-documentos tbody').append(htmlTags);
                })
        }
    })
}

function AbrirDocumento(url){
    url=url.substring(1);
    $("#ImagenHC_1").attr("src",url);
    $("#MostrarImagen").modal('show');
}

function CerrarVerDocumento(){
    $("#MostrarImagen").modal('hide');
}

function CerrarVerPersona(){
    $("#VerFicha").modal('hide');
}

function EliminarDocumento(id){
    id_persona=$("#id_persona").val();
    CerrarVerDocumento();
    CerrarVerPersona();
    cuteAlert({
        type: "question",
        title: "CONFIRMA LA ELIMINACION DEL DOCUMENTO?",
        message: "ESTA ACCION ES IRREVERSIBLE",
        confirmText: "Aceptar",
        cancelText: "Cancelar"
    }).then((e)=>{
        if ( e == ("confirm")){
            $.post("./php/EliminarDocumento.php",{valorBusqueda:id})
            .then(()=>{
                cuteToast({
                    type: "success", // or 'info', 'error', 'warning'
                    message: "Documento borrado con éxito",
                    timer: 3000
                })
                AbrirPersona(id_persona);
            });
      } else {
        cuteToast({
            type: "info", // or 'info', 'error', 'warning'
            message: "ACCION CANCELADA",
            timer: 3000
          })
        }
      })
}

function NuevoDocumento(){
    $("#NuevoDocumento").modal('show');
}

function CerrarNuevoDocumento(){
    $("#NuevoDocumento").modal('hide');
}

function CargarDocumento(){
    var id_persona = $( "#id_persona" ).val();
    var formData = new FormData(document.getElementById("formNuevoDocumento"));
    formData.append("id", id_persona);
    $.ajax({
        url: "./php/recibe.php",
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    }).done((rta)=>{
        console.log(rta);
            cuteToast({
                type: "success", // or 'info', 'error', 'warning'
                message: "Documento cargado con éxito",
                timer: 3000
            })
            CerrarNuevoDocumento();
            CerrarVerPersona();
            AbrirPersona(id_persona);
    });
        
}

function ActualizarPersona(){
    id = $("#id_persona").val();
    nombre = $("#nombre").val();
    fecha_n = $("#fecha_nacimiento").val();
    domicilio = $("#domicilio").val();
    telefono = $("#telefono").val();
    obs = $("#texto_observaciones").val();
    testigo = "@#";
    datos = id+testigo+nombre+testigo+fecha_n+testigo+domicilio+testigo+telefono+testigo+obs;
    console.log(datos);
    $.post("./php/ActualizarPersona.php",{valorBusqueda:datos})
    .then((rta)=>{
       if(rta=="OK"){
        cuteToast({
            type: "success", // or 'info', 'error', 'warning'
            message: "Persona actualizada con éxito.",
            timer: 3000
        })
        CerrarVerPersona();
        AbrirPersona(id);
        CargarPersonas();
       }else{
        cuteToast({
            type: "error", // or 'info', 'error', 'warning'
            message: "Error al Actualizar. Contacte al administrador",
            timer: 3000
        })
       };
    });
}

function AbrirFichaSocial(dni){
    $(".filaGrupo").remove();
    $.post("./php/ObtenerPersonaSocial.php",{valorBusqueda:dni})
    .then((rta) => { //Obtenemos la persona
        var hc = rta.split('@#');
        $("#nombre_social").val(hc[1]);
        $("#dni_social").val(hc[0]);
        $("#estado_civil_social").val(hc[2]);
        $("#fecha_nacimiento_social").val(hc[3]);
        $("#lnacimiento_social").val(hc[4]);
        $("#domicilio_social").val(hc[5]);
        hc[5].includes("*") ? $("#noResidente").prop('hidden',false) : $("#noResidente").prop('hidden',true);
        $("#telefono_social").val(hc[6]);
        $("#celular_social").val(hc[7]);
        $("#email_social").val(hc[8]);
        $("#anios_social").val(hc[9]);
        $("#ocupacion_social").val(hc[10]);
        $("#ingresos_social").val(hc[11]);
        $("#nacionalidad_social").val(hc[12]);
        $("#barrio_social").val(hc[13]);
        $("#educacion_social").val(hc[14]);
        $("#institucion_social").val(hc[15]);
        $("#otra_social").val(hc[16]);

        //Aca vamos a obtener el grupo
            dni = $("#dni_social").val();
            $(".filaGrupo").remove();
            $.post("ObtenerGrupo.php",{valorBusqueda:dni})
            .then((hc)=> {
                if(hc != ""){
                var hc = hc.split('@#');
                var i ;
                cantidad = hc.length-1;
                for (i=1;i<cantidad;i+=10){
                    url = ''+hc[i]+'';
                    var htmlTags = `<tr class="filaGrupo" style="cursor:pointer;">`+
                    '<th scope="row">' + hc[i+1] + '</th>'+
                    '<td>' + hc[i+3] + '</td>'+
                    '<td>' + hc[i+2] + '</td>'+
                    '<td>' + hc[i+4] + '</td>'+
                    '<td>' + hc[i+5] + '</td>'+
                    '<td>' + hc[i+6] + '</td>'+
                    '<td>' + hc[i+7] + '</td>'+
                    '<td>' + hc[i+8] + '</td>'+
                    '<td>' + hc[i+9] + '</td>'+
                    '</tr>';
                    $('#tabla-grupo').append(htmlTags);
                    }
                };
            });
    });
     
    $('#VerFichaSocial').modal('show');
}

function NuevaPersona(){
    $("#dni_nuevo").val("");
    $("#PedirDNI").modal('show');
}

function CerrarPedirDNI(){
    $("#PedirDNI").modal('hide');
}

function BuscarDNI(){
   dni=$("#dni_nuevo").val();
   $.post("./php/VerificarEncuesta.php",{valorBusqueda:dni})
       .then((result)=>{
           if(result=="SI"){
                CerrarPedirDNI();
                cuteAlert({
                    type: "success",
                    title: "La persona se encuentra en la base de datos.",
                    message: "Se cargarán los datos de forma automática. Complete los restantes",
                    buttonText: "OK"
                }).then(()=> {
                    AbrirPersona();
                    $.post("./php/ObtenerPersonaSocial2.php",{valorBusqueda:dni})
                    .then((rta)=>{
                        rta = rta.split('@#');
                        console.log(rta);
                        $("#nombre").val(rta[1]);
                        $("#dni").val(rta[0]);
                        $("#fecha_nacimiento").val(rta[2]);
                        $("#domicilio").val(rta[3]);
                        $("#telefono").val(rta[4]);
                    })
                 });
           }else{
            CerrarPedirDNI();
            cuteAlert({
                type: "info",
                title: "La persona no se encuentra en la base de datos",
                message: "Debe ingresar todos los datos",
                buttonText: "OK"
            }).then(()=>{
                    AbrirPersona();
                })               
           }    
        });
}

function GuardarPersona(){
    dni = $("#dni").val();
    nombre = $("#nombre").val();
    fnac = $("#fecha_nacimiento").val();
    domicilio = $("#domicilio").val();
    telefono = $("#telefono").val();
    var datos = [];
    datos.push(dni,nombre,fnac,domicilio,telefono);
    datos = JSON.stringify(datos);
    if(dni,nombre,domicilio){
        $.post("./php/InsertarPersona.php",{valorBusqueda:datos})
        .then((id)=>{
            cuteToast({
                type: "success", // or 'info', 'error', 'warning'
                message: "Persona guardada con éxito.",
                timer: 3000
            });
            CerrarVerPersona();
            CargarPersonas();
            AbrirPersona(id);
        })
    }else{
        cuteToast({
            type: "error", // or 'info', 'error', 'warning'
            message: "COMPLETA LOS CAMPOS OBLIGATORIOS. <br> NOMBRE, DNI Y DOMICILIO",
            timer: 3000
        });
    }
   
}