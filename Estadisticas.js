function Acceder(){
    clave = "sideso2020";
    pass = prompt("Ingrese la clave de administrador");
    if(clave == pass){
        $('#todo').prop('hidden', false);
    }else{
        alert("CONTRASEÑA INVALIDA. CONTACTE AL ADMINISTRADOR");
        $('#password').val("");
    };
}