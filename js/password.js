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


const icon = document.querySelector("fa-exclamation-circle")
const modal = document.querySelector("dialog")

icon.onclick = function(){
    modal.showModal()
}