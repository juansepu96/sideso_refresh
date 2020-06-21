function Acceder(){
    clave = "sideso2020";
    pass = $('#password').val();
    if(clave == pass){
        $('#Acceder').modal('hide');
        $('#Backup').prop('hidden', false);
    }else{
        alert("CONTRASEÑA INVALIDA. CONTACTE AL ADMINISTRADOR");
        $('#password').val("");
    };
}

function Restaurar(){
    $('#Backup').prop('hidden', true);
    $('#Restore').prop('hidden', false);
}