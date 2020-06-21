function Completar(id){
    $("#actualizar").prop('hidden',false);
    $("#guardar_persona").prop('hidden',true);
    $("#form-persona")[0].reset();
    $(".filaGrupo").remove();
    $(".filaAsistencias").remove();
    $(".filaDocumentos").remove();
    $(".filaEncuestas").remove();
    $.post("ObtenerPersona.php",{valorBusqueda:id}, function(rta) { //Obtenemos la persona
        var hc = rta.split('@#');
        $("#id_persona").val(id);
        $("#dni_persona").val(hc[0]);
        $("#nombre").val(hc[1]);
        $("#dni").val(hc[0]);
        $("#estado_civil").val(hc[2]);
        $("#fecha_nacimiento").val(hc[3]);
        $("#lnacimiento").val(hc[4]);
        $("#domicilio").val(hc[5]);
        hc[5].includes("*") ? $("#noResidente").prop('hidden',false) : $("#noResidente").prop('hidden',true);
        $("#telefono").val(hc[6]);
        $("#celular").val(hc[7]);
        $("#email").val(hc[8]);
        $("#anios").val(hc[9]);
        $("#ocupacion").val(hc[10]);
        $("#ingresos").val(hc[11]);
        $("#nacionalidad").val(hc[12]);
        $("#barrio").val(hc[13]);
        $("#educacion").val(hc[14]);
        $("#institucion").val(hc[15]);
        $("#otra").val(hc[16]);
        $("#texto_observaciones").val(hc[17]);

        //Aca vamos a obtener el grupo
            dni = $("#dni").val();
            $(".filaGrupo").remove();
            $.post("ObtenerGrupo.php",{valorBusqueda:dni}, function(hc) {
                if(hc != ""){
                var hc = hc.split('@#');
                var i ;
                cantidad = hc.length-1;

                for (i=1;i<cantidad;i+=10){
                    url = ''+hc[i]+'';
                    var htmlTags = `<tr class="filaGrupo" style="cursor:pointer;" onclick="AbrirPersonaGrupo('`+url+`');">`+
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

        //Aca vamos a obtener las asistencias
        dni = $("#dni").val();
        $(".filaAsistencias").remove();
        $.post("AbrirAsistencias.php",{valorBusqueda:dni}, function(rta) {
            var hc = rta.split('@#');
               cantidad = hc.length;
                for (i=1;i<cantidad;i=i+7){
                    var htmlTags = '<tr class="filaAsistencias" style="cursor:pointer;" onclick="AbrirAsistencia('+hc[i]+');">' +
                    '<th scope="row">' + hc[i+1] + '</th>' +
                    '<td> $ ' + hc[i+2] + '</td>'+
                    '<td>' + hc[i+3] + '</td>'+
                    '<td>' + hc[i+4] + '</td>'+
                    '<td>' + hc[i+5] + '</td>'+
                    '<td>' + hc[i+6] + '</td>'+
                    '</tr>';
            
                $('#tabla-asistencias').append(htmlTags);
                }
            
        });

        //Aca vamos a obtener las Encuestas
        dni = $("#dni").val();
        $(".filaEncuestas").remove();
        $.post("ObtenerEncuestas.php",{valorBusqueda:dni}, function(rta) {
            var hc = rta.split('@#');
               cantidad = hc.length;
                for (i=1;i<cantidad;i=i+4){
                    var htmlTags = '<tr class="filaEncuestas">'+
                    '<th scope="row">' + hc[i+1] + '</th>' +
                    '<td>' + hc[i+2] + '</td>'+
                    '<td>' + `<button type="button" class="b-0 p-1 btn btn-primary" onclick="AbrirEncuesta('`+hc[i]+`')"> <i class="far fa-folder-open fa-2x"></i> </button>` + '</td>'+
                    '<td>' + `<button type="button" class="b-0 p-1 btn btn-primary bg-danger" onclick="EliminarEncuesta('`+hc[i]+`')"> <i class="far fa-trash-alt fa-2x"></i>  </button>` + '</td>'+

                    '</tr>';
            
                $('#tabla-encuestas').append(htmlTags);
                }
            
        });

        //Aca vamos a obtener los Documentos
        dni = $("#dni").val();
        $(".filaDocumentos").remove();
        $.post("ObtenerDocumentos.php",{valorBusqueda:dni}, function(rta) {
            var hc = rta.split('@#');
               cantidad = hc.length;
                for (i=1;i<cantidad;i=i+4){
                    var htmlTags = '<tr class="filaDocumentos">'+
                    '<th scope="row">' + hc[i+2] + '</th>' +
                    '<td>' + hc[i+1] + '</td>'+
                    '<td>' + `<button type="button" class="b-0 p-1 btn btn-primary" onclick="AbrirDocumento('`+hc[i+1]+`')"> <i class="far fa-folder-open fa-2x"></i> </button>` + '</td>'+
                    '<td>' + `<button type="button" class="b-0 p-1 btn btn-primary bg-danger" onclick="EliminarDocumento('`+hc[i]+`')"> <i class="far fa-trash-alt fa-2x"></i>  </button>` + '</td>'+
                    '</tr>';
            
                $('#tabla-documentos').append(htmlTags);
                }
            
        });
    
    });
     
    $('#VerFicha').modal('show');
}

function ActualizarPersona(){
    id = $("#id_persona").val();
    nombre = $("#nombre").val();
    dni = $("#dni").val();
    estado_civil = $("#estado_civil").val();
    fecha_n = $("#fecha_nacimiento").val();
    domicilio = $("#domicilio").val();
    barrio = $("#barrio").val();
    ocupacion = $("#ocupacion").val();
    telefono = $("#telefono").val();
    lugar_n = $("#lnacimiento").val();
    celular = $("#celular").val();
    email = $("#email").val();
    anios = $("#anios").val();
    ingresos = $("#ingresos").val();
    nacionalidad = $("#nacionalidad").val();
    educacion = $("#educacion").val();
    institucion = $("#institucion").val();
    otra = $("#otra").val();
    obs = $("#texto_observaciones").val();
    testigo = "@#";
    $.post("ObtenerDNIAnterior.php",{valorBusqueda:id}, function(rta) {
        dni_anterior = rta;
    });
    datos = id+testigo+nombre+testigo+dni+testigo+estado_civil+testigo+fecha_n+testigo+domicilio+testigo+barrio+testigo+ocupacion+testigo;
    datos = datos+telefono+testigo+celular+testigo+email+testigo+anios+testigo+ingresos+testigo+nacionalidad+testigo+educacion+testigo;
    datos = datos +institucion+testigo+otra+testigo+dni_anterior+testigo+lugar_n+testigo+obs;

    alert (datos);


    $.post("ActualizarPersona.php",{valorBusqueda:datos}, function(rta) {
       if(rta=="OK"){
           alert("Persona actualizada!");
           $('#VerFicha').modal('hide');
           Completar(id);
       }else{
           alert("Error. Contacte al administrador");
       };
    });


}

function AbrirPersonaGrupo(id){
    $.post("ObtenerFamiliar.php",{valorBusqueda:id}, function(rta) { //Obtenemos la persona
        var hc = rta.split('@#');
        $("#id_familiar").val(id);
        $("#dni_familiar").val(hc[1]);
        $("#dni_familiar2").val(hc[1]);
        $("#nombre_familiar").val(hc[2]);
        $("#vinculo_familiar").val(hc[3]);
        $("#fecha_nacimiento_familiar").val(hc[4]);
        $("#ocupacion_familiar").val(hc[5]);
        $("#ingresos_familiar").val(hc[6]);
        $("#educacion_familiar").val(hc[7]);
        $("#institucion_familiar").val(hc[8]);
        $("#otra_familiar").val(hc[9]);
        $("#actualizar_familiar").prop('hidden',false);
        $("#borrar_familiar").prop('hidden',false);
        $("#nuevo_familiar").prop('hidden',true);
        $("#VerIntegrante").modal('show');
    });
}

function ActualizarFamiliar(){
    id = $("#id_familiar").val();
    dni = $("#dni_familiar2").val();
    nombre = $("#nombre_familiar").val();
    vinculo = $("#vinculo_familiar").val();
    fecha = $("#fecha_nacimiento_familiar").val();
    ocupacion = $("#ocupacion_familiar").val();
    ingresos = $("#ingresos_familiar").val();
    educacion = $("#educacion_familiar").val();
    institucion = $("#institucion_familiar").val();
    otra = $("#otra_familiar").val();
    testigo = "@#";
    datos = id+testigo+dni+testigo+nombre+testigo+vinculo+testigo+fecha+testigo+ocupacion+testigo+ingresos+testigo;
    datos = datos+educacion+testigo+institucion+testigo+otra;    
    $.post("ActualizarFamiliar.php",{valorBusqueda:datos}, function(rta) {
        if(rta=="OK"){
                alert("Familiar actualizado con éxito");
                $("#VerIntegrante").modal('hide');
                $("#VerFicha").modal('hide');
                id = $("#id_persona").val();
                Completar(id);
        }else{
            alert("Error al actualizar familiar. Contacte al administrador");
        };
     });

}

function BorrarFamiliar(){
    nombre = $("#nombre_familiar").val();
    nombre2 = $("#nombre").val();
    if(confirm("¿Confirma realmente que quiere eliminar a "+nombre+" del grupo familiar de "+nombre2+" ?")){
        id = $("#id_familiar").val();
        $.post("EliminarFamiliar.php",{valorBusqueda:id}, function(rta) {
            if(rta=="OK"){
                    alert("Familiar eliminado con éxito");
                    $("#VerIntegrante").modal('hide');
                    $("#VerFicha").modal('hide');
                    id = $("#id_persona").val();
                    Completar(id);
            }else{
                alert("Error al eliminar familiar. Contacte al administrador");
            };
         });

    }else{
        alert ("Accion Cancelada");
    }
}

function NuevoIntegrante(){
    $("#form-familiar")[0].reset();
    $("#actualizar_familiar").prop('hidden',true);
    $("#borrar_familiar").prop('hidden',true);
    $("#nuevo_familiar").prop('hidden',false);
    $("#VerIntegrante").modal('show');
}

function NuevoFamiliar(){
    dni_titular = $("#dni").val();
    dni = $("#dni_familiar2").val();
    nombre = $("#nombre_familiar").val();
    vinculo = $("#vinculo_familiar").val();
    fecha = $("#fecha_nacimiento_familiar").val();
    ocupacion = $("#ocupacion_familiar").val();
    ingresos = $("#ingresos_familiar").val();
    educacion = $("#educacion_familiar").val();
    institucion = $("#institucion_familiar").val();
    otra = $("#otra_familiar").val();
    testigo = "@#";
    datos = dni_titular+testigo+dni+testigo+nombre+testigo+vinculo+testigo+fecha+testigo+ocupacion+testigo+ingresos+testigo;
    datos = datos+educacion+testigo+institucion+testigo+otra;    
    $.post("NuevoFamiliar.php",{valorBusqueda:datos}, function(rta) {
        if(rta=="OK"){
                alert("Familiar cargado con éxito");
                $("#VerIntegrante").modal('hide');
                $("#VerFicha").modal('hide');
                Completar(dni_titular);
        }else{
            alert("Error al cargar familiar. Contacte al administrador");
        };
     });
}

function AbrirDocumento(url){
    $("#ImagenHC_1").attr("src",url);
    $("#MostrarImagen").modal('show');
}

function NuevoDocumento(){
    $("#NuevoDocumento").modal('show');
    
}

function CargarDocumento(){
    var persona = $( "#dni" ).val();
    var formData = new FormData(document.getElementById("formNuevoDocumento"));
    formData.append("dni", persona);
    $.ajax({
        url: "recibe.php",
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    })
        .done(function(res){
            alert("Documento cargado con exito!");
            //Aca vamos a obtener los Documentos
            $(".filaDocumentos").remove();
            var persona = $( "#dni" ).val();
            $.post("ObtenerDocumentos.php",{valorBusqueda:persona}, function(rta) {
                var hc = rta.split('@#');
                cantidad = hc.length;
                    for (i=1;i<cantidad;i=i+4){
                        var htmlTags = '<tr class="filaDocumentos">'+
                        '<th scope="row">' + hc[i+2] + '</th>' +
                        '<td>' + hc[i+1] + '</td>'+
                        '<td>' + `<button type="button" class="b-0 p-1 btn btn-primary" onclick="AbrirDocumento('`+hc[i+1]+`')"> <i class="far fa-folder-open fa-2x"></i> </button>` + '</td>'+
                        '<td>' + `<button type="button" class="b-0 p-1 btn btn-primary bg-danger" onclick="EliminarDocumento('`+hc[i]+`')"> <i class="far fa-trash-alt fa-2x"></i>  </button>` + '</td>'+
                        '</tr>';
                    $('#tabla-documentos').append(htmlTags);
                    }
            
             });
            //fin del insertar
            $("#NuevoDocumento").modal('hide');
            var persona = $( "#id_persona" ).val();
           Completar(persona);
        });
        
}

function CerrarDocumento(){
    $("#NuevoDocumento").modal('hide');
    var persona = $( "#id_persona" ).val();
    Completar(persona);
}

function AbrirAsistencia (id){
    $("#actualizar_asistencia").prop('hidden',false);
    $("#guardar_asistencia").prop('hidden',true);
    $("#borrar_asistencia").prop('hidden',false);
    $("#tipo_asistencia").prop('disabled',false);
    $("#fecha_asistencia").prop('disabled',false);
    $.post("ObtenerAsistencia.php",{valorBusqueda:id}, function(rta) {
        var hc = rta.split('@#');
        $("#id_asistencia").val(id);
        $("#tipo_asistencia").val(hc[0]);
        $("#monto_asistencia").val(hc[1]);
        $("#fecha_asistencia").val(hc[4]);
        $("#estado_asistencia").val(hc[2]);
        $("#observaciones_asistencia").val(hc[3]);
        $("#id_persona_3").val(hc[5]);
        $("#AbrirAsistencia").modal('show');
    });

    persona = $("#id_persona").val();
    $("$id_persona_4").val(persona);
}

function ActualizarAsistencia(){
    id = $("#id_asistencia").val();
    monto = $("#monto_asistencia").val();
    estado = $("#estado_asistencia").val();
    observaciones = $("#observaciones_asistencia").val();
    ultima = $("#fecha_modificacion").val();
    persona = $("#id_persona").val();
    fecha = $("#fecha_asistencia").val();
    tipo = $("#tipo_asistencia").val();
    datos = id+"@#"+monto+"@#"+estado+"@#"+observaciones+"@#"+ultima+"@#"+fecha+"@#"+tipo;
    $.post("ActualizarAsistencia.php",{valorBusqueda:datos}, function(rta) {
        if(rta=="OK"){
            alert("Actualizada con Exito");
            $("#AbrirAsistencia").modal('hide');
            $("#form_asistencias")[0].reset();
            $("#VerFicha").modal('hide');
            Completar(persona);

        }else{
            alert("Error. Contacte al administrador");
        };
    });    

}

function NuevaAsistencia(){
    $("#form_asistencias")[0].reset();    
    $("#actualizar_asistencia").prop('hidden',true);
    $("#guardar_asistencia").prop('hidden',false);
    $("#borrar_asistencia").prop('hidden',true);
    $("#tipo_asistencia").prop('disabled',false);
    $("#fecha_asistencia").prop('disabled',false);
    $("#AbrirAsistencia").modal('show');
}

function GuardarAsistencia(){
    monto = $("#monto_asistencia").val();
    estado = $("#estado_asistencia").val();
    tipo = $("#tipo_asistencia").val();
    observaciones = $("#observaciones_asistencia").val();
    fecha = $("#fecha_asistencia").val();
    persona = $("#dni").val();
    persona2 = $("#id_persona").val();
    datos = persona+"@#"+tipo+"@#"+monto+"@#"+observaciones+"@#"+fecha+"@#"+estado;
    $.post("InsertarAsistencia.php",{valorBusqueda:datos}, function(rta) {
        if(rta=="OK"){
            alert("Nueva Asistencia cargada!");
            $("#AbrirAsistencia").modal('hide');
            $("#form_asistencias")[0].reset();
            $("#VerFicha").modal('hide');    
            Completar(persona2);
        }else{
            alert("Error. Contacte al administrador");
        };
    });   
}

function BorrarAsistencia(){
    id = $("#id_asistencia").val();
    persona = $("#id_persona").val();
    $("#id_asistencia_borrar").val(id);
    $("#id_persona_borrar").val(persona);
    $("#Acceder").modal('show');
}

function EliminarDefinitivo(){
    id = $("#id_asistencia_borrar").val();
    persona = $("#id_persona_borrar").val();
    clave = "sideso2020";
    clave2 = "dsocial2020";
    pass = $('#password').val();
    if((clave == pass) || (clave2==pass)){
        $.post("EliminarAsistencia.php",{valorBusqueda:id}, function(rta) {
            if(rta=="OK"){
                alert("Asistencia Eliminada!");  
                $("#Acceder").modal('hide');
                $("#AbrirAsistencia").modal('hide');
                $("#VerAsistencias").modal('hide');
                $("#form_asistencias")[0].reset();
                Completar(persona);
            }else{
                alert("Error. Contacte al administrador");
            };
        }); 
    }else{
        alert("CONTRASEÑA INVALIDA. CONTACTE AL ADMINISTRADOR");
        $('#password').val("");
    };
}

function AbrirEncuesta(id){
    $.post("GrabarEncuesta.php",{valorBusqueda:id}, function(rta) {
        url = "AbrirEncuesta.php";
          window.open(url, '_blank');
    }); 

}
function EliminarEncuesta(id){
    $("#id_encuesta_borrar").val(id);
    $("#Acceder2").modal('show');
}

function EliminarEncuestaDefinitivo(){
    id = $("#id_encuesta_borrar").val();
    persona = $("#id_persona").val();
    clave = "sideso2020";
    pass = $('#password2').val();
    if(clave == pass){
        $.post("EliminarEncuesta.php",{valorBusqueda:id}, function(rta) {
            if(rta=="OK"){
                alert("Encuesta Eliminada!");  
                $("#Acceder2").modal('hide');
                $("#form_asistencias")[0].reset();
                $("#VerFicha").modal('hide');    
                Completar(persona);
            }else{
                alert("Error. Contacte al administrador");
            };
        }); 
    }else{
        alert("CONTRASEÑA INVALIDA. CONTACTE AL ADMINISTRADOR");
        $('#password2').val("");
    };

}

function NuevaEncuesta(){
    persona = $("#dni").val();
    $.post("ObtenerUltimaEncuesta.php",{valorBusqueda:persona}, function(rta) {
        ultima=rta;
    });
    var fecha = new Date();
    var ano = fecha.getFullYear();
    if(ultima==ano){
        alert("Error! Ya existe una encuesta del año en curso. Debe eliminar dicha encuesta para realizar una nueva");
    }else{
        $("#NuevaEncuesta").modal('show');
        $("#form-encuesta")[0].reset();
    }

}

function VerificarSepelios(){
    sepelio = $("#sepelio").val();
    if(sepelio=="SI"){
        $("#sepelio_nombre_d").prop('hidden',false);
    }else{
        $("#sepelio_nombre_d").prop('hidden',true);
    };
}

function VerificarTenencia(){
    tenencia = $("#tenencia_vivienda").val();
    if(tenencia=="Alquilada"){
        $("#monto_tenencia_d").prop('hidden',false);
    }else{
        $("#monto_tenencia_d").prop('hidden',true);
    };
}

function VerificarOS(){
    os = $("#os").val();
    if(os=="SI"){
        $("#osocial_d").prop('hidden',false);
    }else{
        $("#osocial_d").prop('hidden',true);
    };
}

function GuardarEncuesta(){
    pregunta = confirm("Esta a punto de guardar la encuesta. Desea continuar?");
    if(pregunta){
        persona = $("#dni").val();
        tipo = $("#tipo_vivienda").val();
        tenencia = $("#tenencia_vivienda").val();
        monto = $("#monto_tenencia").val();
        pisos = $("#material_pisos").val();
        paredes = $("#material_paredes").val();
        cubierta = $("#cubiera_exterior").val();
        rev = $("#rev_interior").val();
        electricidad = $("#electricidad").val();
        agua = $("#agua").val();
        desague = $("#desague").val();
        gas = $("#gas").val();
        otrosing = $("#otros_ingresos").val();
        otrosbi = $("#otros_bienes").val();
        sepelio = $("#sepelio").val();
        sepelioNom = $("#sepelio_nombre").val();
        os = $("#os").val();
        osNom = $("#osocial").val();
        observaciones = $("#observaciones").val();
        salud = $("#salud").val();
        testigo="@#";
        datos = persona+testigo+tipo+testigo+tenencia+testigo+monto+testigo+pisos+testigo+paredes+testigo+cubierta+testigo;
        datos = datos+rev+testigo+electricidad+testigo+agua+testigo+desague+testigo+gas+testigo+otrosing+testigo+otrosbi+testigo;
        datos = datos+sepelio+testigo+sepelioNom+testigo+os+testigo+osNom+testigo+observaciones+testigo+salud;
            $.post("InsertarEncuesta.php",{valorBusqueda:datos}, function(rta) {
                if(rta=="OK"){
                    alert("Encuesta Cargada con éxito!");  
                    $("#NuevaEncuesta").modal('hide');
                    persona = $("#id_persona").val();
                    $("#VerFicha").modal('hide');    
                    Completar(persona);
                }else{
                    alert("Error. Contacte al administrador");
                };
            }); 
    }else{
        alert("Accion cancelada!");
    };
}

function NuevaPersona(){
    $("#form-persona")[0].reset();
    $("#menu-2").prop('hidden',true);
    $("#actualizar").prop('hidden',true);
    $("#guardar_persona").prop('hidden',false);
    $("#VerFicha").modal('show');
}

function GuardarPersona(){
    nombre = $("#nombre").val();
    dni = $("#dni").val();
    estado_civil = $("#estado_civil").val();
    fecha_n = $("#fecha_nacimiento").val();
    lugar_n = $("#lnacimiento").val();
    domicilio = $("#domicilio").val();
    barrio = $("#barrio").val();
    ocupacion = $("#ocupacion").val();
    telefono = $("#telefono").val();
    celular = $("#celular").val();
    email = $("#email").val();
    anios = $("#anios").val();
    ingresos = $("#ingresos").val();
    nacionalidad = $("#nacionalidad").val();
    educacion = $("#educacion").val();
    institucion = $("#institucion").val();
    otra = $("#otra").val();
    testigo = "@#";
    datos = nombre+testigo+dni+testigo+estado_civil+testigo+fecha_n+testigo+lugar_n+testigo+domicilio+testigo+barrio+testigo+ocupacion+testigo;
    datos = datos+telefono+testigo+celular+testigo+email+testigo+anios+testigo+ingresos+testigo+nacionalidad+testigo+educacion+testigo;
    datos = datos +institucion+testigo+otra;

    $.post("InsertarPersona.php",{valorBusqueda:datos}, function(rta) {
        if(rta=="OK"){
            alert("Persona agregada con éxito!");
            alert("Ahora podrá continuar con la carga.");
            location.reload();
        }else{
            alert("Error. Contacte al administrador");
        };
     });
 

}

function EliminarDocumento(id){

    conf = confirm("Desea realmente eliminar este documento?");
    if(conf){
        $.post("EliminarDocumento.php",{valorBusqueda:id}, function(rta) {
            if(rta=="OK"){
                alert("Documento eliminado con éxito!");
                $(".filaDocumentos").remove();
                var persona = $( "#dni" ).val();
                $.post("ObtenerDocumentos.php",{valorBusqueda:persona}, function(rta) {
                    var hc = rta.split('@#');
                    cantidad = hc.length;
                        for (i=1;i<cantidad;i=i+4){
                            var htmlTags = '<tr class="filaDocumentos">'+
                            '<th scope="row">' + hc[i+2] + '</th>' +
                            '<td>' + hc[i+1] + '</td>'+
                            '<td>' + `<button type="button" class="b-0 p-1 btn btn-primary" onclick="AbrirDocumento('`+hc[i+1]+`')"> <i class="far fa-folder-open fa-2x"></i> </button>` + '</td>'+
                            '<td>' + `<button type="button" class="b-0 p-1 btn btn-primary bg-danger" onclick="EliminarDocumento('`+hc[i]+`')"> <i class="far fa-trash-alt fa-2x"></i>  </button>` + '</td>'+
                            '</tr>';
                        $('#tabla-documentos').append(htmlTags);
                        }
                 });

            }else{
                alert("Error. Contacte al administrador");
            };
         });
    }else{
        alert("Operacion Cancelada!!");
    }

}