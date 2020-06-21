function Completar (id){
    $('.filaBusqueda').remove();
    $('#id_persona1').val(id);
    $.post("AbrirAsistencias.php",{valorBusqueda:id}, function(rta) {
        var hc = rta.split('@#');
           cantidad = hc.length;
            for (i=1;i<cantidad;i=i+7){
                var htmlTags = '<tr class="filaBusqueda" style="cursor:pointer;" onclick="AbrirAsistencia('+hc[i]+');">' +
                '<th scope="row">' + hc[i+1] + '</th>' +
                '<td> $ ' + hc[i+2] + '</td>'+
                '<td>' + hc[i+3] + '</td>'+
                '<td>' + hc[i+4] + '</td>'+
                '<td>' + hc[i+5] + '</td>'+
                '<td>' + hc[i+6] + '</td>'+
                '</tr>';
        
            $('#ResultadoAsistencias').append(htmlTags);
            }
        
    });
    $('#VerAsistencias').modal('show');
}

function AbrirAsistencia (id){
    $("#actualizar_asistencia").prop('hidden',false);
    $("#guardar_asistencia").prop('hidden',true);
    $("#borrar_asistencia").prop('hidden',false);
    $("#tipo_asistencia").prop('disabled',true);
    $("#fecha_asistencia").prop('disabled',true);
    $.post("ObtenerAsistencia.php",{valorBusqueda:id}, function(rta) {
        var hc = rta.split('@#');
        $("#id_asistencia").val(id);
        $("#tipo_asistencia").val(hc[0]);
        $("#monto_asistencia").val(hc[1]);
        $("#fecha_asistencia").val(hc[4]);
        $("#estado_asistencia").val(hc[2]);
        $("#observaciones_asistencia").val(hc[3]);
        $("#id_persona").val(hc[5]);
        $("#AbrirAsistencia").modal('show');
    });
}

function ActualizarAsistencia(){
    id = $("#id_asistencia").val();
    monto = $("#monto_asistencia").val();
    estado = $("#estado_asistencia").val();
    observaciones = $("#observaciones_asistencia").val();
    ultima = $("#fecha_modificacion").val();
    persona = $("#id_persona").val();
    datos = id+"@#"+monto+"@#"+estado+"@#"+observaciones+"@#"+ultima;

    $.post("ActualizarAsistencia.php",{valorBusqueda:datos}, function(rta) {
        if(rta=="OK"){
            alert("Actualizada con Exito");
            $("#AbrirAsistencia").modal('hide');
            $("#VerAsistencias").modal('hide');
            $("#form_asistencias")[0].reset();
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
    id = $("#id_persona1").val();
    $("#id_persona").val(id);
    $("#tipo_asistencia").prop('disabled',false);
    $("#fecha_asistencia").prop('disabled',false);
    $("#AbrirAsistencia").modal('show');
}

function Guardar(){
    monto = $("#monto_asistencia").val();
    estado = $("#estado_asistencia").val();
    tipo = $("#tipo_asistencia").val();
    observaciones = $("#observaciones_asistencia").val();
    fecha = $("#fecha_asistencia").val();
    persona = $("#id_persona").val();
    datos = persona+"@#"+tipo+"@#"+monto+"@#"+observaciones+"@#"+fecha+"@#"+estado;
    $.post("InsertarAsistencia.php",{valorBusqueda:datos}, function(rta) {
        if(rta=="OK"){
            alert("Nueva Asistencia cargada!");
            $("#AbrirAsistencia").modal('hide');
            $("#VerAsistencias").modal('hide');
            $("#form_asistencias")[0].reset();
            Completar(persona);
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
    pass = $('#password').val();
    if(clave == pass){
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
