var promesas = [];



function CargarEnTabla(rta){
    $(".filaPersonas").remove();
    if(rta.length>0){
        rta.map((e)=>{
                fecha = moment(e.date);
                fecha = fecha.format("DD/MM/YYYY");
                var htmlTags = '<tr class="filaPersonas" >' +
                    '<td onclick="AbrirPersona('+e.ID+');">' + e['DNI'] + '</td>' +
                    '<td onclick="AbrirPersona('+e.ID+');">' + e['legajo'] + '</td>' +
                    '<td onclick="AbrirPersona('+e.ID+');" >' + e['nombre'] + '</td>'+
                    '<td onclick="AbrirPersona('+e.ID+');">' + fecha + '</td>';
                    $.post("./php/VerificarEncuesta.php",{valorBusqueda:e.DNI})
                        .then((result)=>{
                            if(result=="SI"){
                                htmlTags=htmlTags+'<td style="color:green; font-weight: bold;" onclick="AbrirFichaSocial('+e.DNI+');">SI</td></tr>';
                            }else{
                                htmlTags=htmlTags+'<td style="color:red; font-weight: bold;">NO</td></tr>';
                            }
                            $('#tabla-personas tbody').append(htmlTags);
                    });
        })
    }
}

function CargarPersonas(){
    $.post("./php/slocal/CargarPersonas.php")
    .then((rta)=>{
        rta=JSON.parse(rta);
        CargarEnTabla(rta);
    })
}

function OrdenarPorLegajo(){
    $.post("./php/slocal/OrdenarPorLegajo.php")
    .then((rta)=>{
        rta=JSON.parse(rta);
        rta.sort(function (a, b) {
            if (a.legajo > b.legajo) {
              return 1;
            }
            if (a.legajo < b.legajo) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
        CargarEnTabla(rta);
    })
}

function BuscarPersonas(){
    dato=$("#buscar").val();
    $.post("./php/slocal/BuscarPersonas.php",{valorBusqueda:dato})
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
        $.post("./php/slocal/ObtenerDatosPersona.php",{valorBusqueda:id})
        .then((rta)=>{
            rta=JSON.parse(rta);
            rta.forEach((e)=>{
                $("#id_persona").val(e.ID);
                $("#dni_persona").val(e.DNI);
                $("#dni").val(e.DNI);
                $("#nombre").val(e.nombre);
                $("#legajo").val(e.legajo);
                $("#fecha_nacimiento").val(e.date);
                $("#domicilio").val(e.domicilio);
                $("#telefono").val(e.telefono);
                $("#texto_observaciones").val(e.obs);
                $("#motivo").val(e.motivo);
                ObtenerIntervenciones(e.ID);
                CargarDocumentos(e.ID);
            })
           
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
    $(".filaIntervenciones").remove();
    $.post("./php/slocal/ObtenerIntervenciones.php",{valorBusqueda:id})
    .then((response)=>{
        response=JSON.parse(response);
        response.forEach((el)=>{
            fecha = moment(el.fecha);
            fecha = fecha.format("DD/MM/YYYY");
            var htmlTags = '<tr class="filaIntervenciones"  >' +
            '<td onclick="AbrirIntervencion('+el.ID+');">' + fecha + '</td>' +
            '<td onclick="AbrirIntervencion('+el.ID+');">' + el.tipo + '</td>' +
            '<td onclick="AbrirIntervencion('+el.ID+');">' + el.intervino + '</td>';
            if(el.doc){
                doc=el.doc;
                doc=doc.substring(4);
                htmlTags=htmlTags+'<td>' + '<a href="'+doc+'" target="_blank"> DESCARGAR </a> </td>';
            }else{
                htmlTags=htmlTags+'<td>----</td>';
            }
            htmlTags=htmlTags+'<td>' + `<button type="button" class="b-0 p-1 btn btn-primary bg-success mr-2" onclick="ImprimirIntervencion('`+el.ID+`')"> <i class="fas fa-print fa-2x"></i>  </button>`+  `<button type="button" class="b-0 p-1 btn btn-primary bg-danger" onclick="EliminarIntervencion('`+el.ID+`')"> <i class="far fa-trash-alt fa-2x"></i>  </button>` + '</td></tr>';
            $('#tabla-intervenciones tbody').append(htmlTags);
        })
    })
}

function EliminarIntervencion(id){
    
    conf = confirm("Desea realmente eliminar esta intervencion?");
    if(conf){
        $.post("./php/slocal/EliminarIntervencion.php",{valorBusqueda:id})
        .then((rta)=>{
            if(rta=="OK"){
                cuteToast({
                    type: "success", // or 'info', 'error', 'warning'
                    message: "intervencion eliminada con éxito.",
                    timer: 5000
                });
                var persona = $( "#id_persona" ).val();
                console.log(persona);
                ObtenerIntervenciones(persona);              

            }else{
                cuteToast({
                    type: "error", // or 'info', 'error', 'warning'
                    message: "Error al eliminar internvencion.",
                    timer: 5000
                });
            };
         });
    }else{
        cuteToast({
            type: "info", // or 'info', 'error', 'warning'
            message: "Accion cancelada.",
            timer: 5000
        });
    }
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
    tipo = $("#tipo_inter").val();
    datos.push(fecha,detalle,id,tipo);
    datos=JSON.stringify(datos);
    $.post("./php/slocal/NuevaIntervencion.php",{valorBusqueda:datos})
    .then((id2)=>{
        var formData = new FormData(document.getElementById("formDocumento"));
        formData.append("id", id2);
            $.ajax({
                url: "./php/slocal/recibe2.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
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
    $.post("./php/slocal/ObtenerDocumentos.php",{valorBusqueda:id})
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
    url=url.substring(4);
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
            $.post("./php/slocal/EliminarDocumento.php",{valorBusqueda:id})
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
        url: "./php/slocal/recibe.php",
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
    legajo = $("#legajo").val();
    telefono = $("#telefono").val();
    obs = $("#texto_observaciones").val();
    motivo=$("#motivo").val();
    testigo = "@#";
    datos = id+testigo+nombre+testigo+fecha_n+testigo+domicilio+testigo+telefono+testigo+obs+testigo+legajo+testigo+motivo;
    $.post("./php/slocal/ActualizarPersona.php",{valorBusqueda:datos})
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
    legajo = $("#legajo").val();
    motivo = $("#motivo").val();
    var datos = [];
    datos.push(dni,nombre,fnac,domicilio,telefono,legajo,motivo);
    datos = JSON.stringify(datos);
    if(dni,nombre,domicilio){
        $.post("./php/slocal/InsertarPersona.php",{valorBusqueda:datos})
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

function AbrirIntervencion(id){
    $.post("./php/slocal/ObtenerIntervencion.php",{valorBusqueda:id})
    .then((response)=>{
        response=JSON.parse(response);
        response.forEach((el)=>{
            $("#fecha_inter_1").val(el.fecha);
            $("#tipo_1").val(el.tipo);
            $("#intervino_1").val(el.intervino);
            $("#detalle_inter1").val(el.detalle);
        })
        $("#verIntervencion").modal('show');
    })

}

function CerrarVerIntervencion(){
    $("#verIntervencion").modal('hide');
}

function ImprimirIntervencion(id){
    id2=$("#id_persona").val();
    $.post("./php/slocal/CargarDatosExportar.php",{valorBusqueda:id,valorBusqueda2:id2})
    .then(()=>{
        window.open("./php/slocal/ImprimirIntervencion.php", '_blank');
    })
}