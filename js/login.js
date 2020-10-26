//ROLES :
//1 : ACCESO A TODO
//2 : ACCESO A SIDESO
//3 : ACCESO A MUJER
//4 : ACCESO A SLOCAL
//5 : ACCESO A SIDESO + SLOCAL
//6 : ACCESO A SIDESO + MUJER
//7 : ACCESO A MUJER + SLOCAL

var desarrollo = ' <div class="col-sx-12 col-md-6 col-lg-6 col-xl-4"> '+
' <div class="card" style="width: 20rem;" onclick="AccesoDesarrollo();"> '+
'   <img class="card-img-top" src="./icon.jpg" alt="Card image cap">'+
'   <div class="card-body">'+
'        <p class="card-text texto">Acceso Desarrollo Social</p>'+
'    </div>'+
'    </div>'+
'  </div>';

var mujer = '  <div class="col-sx-12 col-md-6 col-lg-6 col-xl-4">'+
'  <div class="card" style="width: 20rem;" onclick="AccesoMujeres();">'+
'     <img class="card-img-top" src="mujeres.jpg" alt="Card image cap">'+
'     <div class="card-body">'+
'         <p class="card-text texto">Acceso Dirección de la Mujer</p>'+
'     </div>'+
'     </div>'+
' </div>';

var servicio = '  <div class="col-sx-12 col-md-6 col-lg-6 col-xl-4">'+
'      <div class="card" style="width: 20rem;" onclick="AccesoSLocal();">'+
'           <img class="card-img-top" src="slocal.jpg" alt="Card image cap">'+
'           <div class="card-body">'+
'            <p class="card-text texto">Acceso Servicio Local</p>'+
'            </div>'+
'         </div>'+
'     </div>';



function CargarAccesos(){
    $.post("ObtenerRol.php")
    .then((rta) =>{
        rta=parseInt(rta);
        switch (rta) {
            case 1:
              html=desarrollo+mujer+servicio;              
            break;
            case 2:
              html=desarrollo;
            break;
            case 3:
              html=mujer;
            break;
            case 4:
              html=servicio;
            break;
            case 5:
              html=desarrollo+servicio;
            break;
            case 6:
              html=desarrollo+mujer;
            break;
            case 7:
              html=mujer+servicio;
            break;
        }
        $("#logos").html(html);
    })
}