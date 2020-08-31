function CargarEnTabla(fecha){
    $(".filaCitas").remove();
    fecha=JSON.stringify(fecha);
    $.post("./php/CargarCitas.php",{valorBusqueda:fecha})
    .then((rta) => {
        console.log(rta);
        array=JSON.parse(rta);
        if(array.length>0){
                array.map((e)=>{
                hora = e.time;
                hora=hora.substring(0,5);
                    var htmlTags = '<tr class="filaCitas" >' +
                        '<td>' + hora + '</td>' +
                        '<td >' + e.detail + '</td>'+
                        '<td>' + e.intervino + '</td>';
                        $('#tabla-citas tbody').append(htmlTags);
                })
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
    detalle=$("#detalle").val();
    datos=[];
    datos.push(fecha,hora,detalle);
    datos=JSON.stringify(datos);
    console.log(datos);
    if(fecha && hora && detalle){
        $.post("./php/NuevaCita.php",{valorBusqueda:datos})
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