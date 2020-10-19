function CargarEnTabla(fecha){
    $(".filaCitas").remove();
    
    $.post("./php/slocal/CargarCitas.php",{valorBusqueda:fecha})
    .then((rta) => {
        array=JSON.parse(rta);
        if(array.length>0){
                array.map((e)=>{
                hora = e.time;
                hora=hora.substring(0,5);
                    var htmlTags = '<tr class="filaCitas" onclick="AbrirCita('+e.ID+');">' +
                        '<td>' + hora + '</td>' +
                        '<td >' + e.description + '</td>'+
                        '<td>' + e.intervino + '</td>';
                        $('#tabla-citas tbody').append(htmlTags);
                });                
        }
    });
}
    
    

function CargarCitas(){
    var fecha = moment();
    fecha = fecha.format("YYYY-MM-DD");
    $("#fecha").val(fecha);
    CargarEnTabla(fecha);
}

function BuscarCitas(){
    fecha=$("#fecha").val();
    CargarEnTabla(fecha);
}

function NuevaCita(){
    $("#fecha_n").prop('readonly',false);
    $("#hora").prop('readonly',false);
    $("#descripcion").prop('readonly',false);
    $("#detalle").prop('readonly',false);
    $("#boton_guardar").prop('hidden',false);
    $('#nuevaCita').modal('show');
}

function CerrarCita(){
    $('#nuevaCita').modal('hide');
    $("#fecha_n").val("");
    $("#hora").val("");
    $("#detalle").val("");
}

function GuardarCita(){
    fecha=$("#fecha_n").val();
    hora=$("#hora").val();
    descripcion=$("#descripcion").val();
    detalle=$("#detalle").val();
    datos=[];
    datos.push(fecha,hora,descripcion,detalle);
    datos=JSON.stringify(datos);
    console.log(datos);
    if(fecha && hora && detalle){
        $.post("./php/slocal/NuevaCita.php",{valorBusqueda:datos})
        .then(()=>{
            cuteToast({
                type: "success", // or 'info', 'error', 'warning'
                message: "CITA GUARDADA CON ÉXITO.",
                timer: 3000
            });
            CerrarCita();
            CargarCitas();
        })
    }else{
        cuteToast({
            type: "error", // or 'info', 'error', 'warning'
            message: "COMPLETE TODOS LOS CAMPOS",
            timer: 3000
        });
    }
    
}

function AbrirCita(id){
    $.post("./php/slocal/ObtenerCita.php",{valorBusqueda:id})
    .then((rta)=>{
        rta=JSON.parse(rta);
        rta=rta[0];
        $("#fecha_n").val(rta.date);
        $("#hora").val(rta.time);
        $("#descripcion").val(rta.description);
        $("#detalle").val(rta.detail);
        NuevaCita();
        $("#fecha_n").prop('readonly',true);
        $("#hora").prop('readonly',true);
        $("#descripcion").prop('readonly',true);
        $("#detalle").prop('readonly',true);
        $("#boton_guardar").prop('hidden',true);
    })
}