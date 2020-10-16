function BuscarIntervenciones(){
    $(".filaIntervenciones").remove();
    var datos=[];
    fecha1=$("#fecha-desde").val();
    fecha2=$("#fecha-hasta").val();
    datos.push(fecha1,fecha2);
    datos=JSON.stringify(datos);
    $.post("./php/slocal/ListarIntervenciones.php",{valorBusqueda:datos})
    .then((rta)=>{
        rta=JSON.parse(rta);
        rta.forEach((e)=>{
                $.post("./php/slocal/ObtenerDatosPersona.php",{valorBusqueda:e.persona_ID})
                .then((res)=>{
                    res=JSON.parse(res);
                    fecha = moment(e.fecha);
                    fecha = fecha.format("DD/MM/YYYY");
                    var htmlTags = '<tr class="filaIntervenciones" >' +
                        '<td>' + fecha + '</td>' +
                        '<td >' + res[0].DNI + '</td>'+
                        '<td >' + res[0].nombre + '</td>'+
                        '<td>' + e.intervino + '</td>';
                    $('#tabla-intervenciones tbody').append(htmlTags);
                })
                
        })
    })
    $("#fecha-desde").val(fecha1);
    $("#fecha-hasta").val(fecha2);
}