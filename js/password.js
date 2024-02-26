function mostrarSenha(){
    var inputPass = document.getElementById('inputPass')
    var btnShowPass = document.getElementById('openeye')

    if(inputPass.type === 'password'){
        inputPass.setAttribute('type', 'text')
        btnShowPass.classList.replace('fa-eye', 'fa-eye-slash')
    }else{
        inputPass.setAttribute('type', 'password')
        btnShowPass.classList.replace('fa-eye-slash', 'fa-eye')
    }
}

function capsLock(){
document.getElementById('inputPass').onkeyup = function (e) {

    var key = e.charCode || e.keyCode;
    
    //enter, caps lock e backspace não interessam
    if(key == 13 || key == 8 || key == 46 || key == 20){
      return false;
    }
    
    //pega o último caracter digitado
      var tamanho = this.value.length
      var ultimo_caracter = this.value.substring(tamanho - 1);
    
    //Verifica se é maiúsculo, e se não é shift
    if(ultimo_caracter.toUpperCase() == ultimo_caracter 
    && ultimo_caracter.toLowerCase() != ultimo_caracter
    && !e.shiftKey)
    {
        alert('Caps Lock está pressionado!');
    }
  };
}