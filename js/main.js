/**
 * Exibe mais informações sobre o projeto
 */
document.getElementById("btn-sobre").addEventListener("click", function(e) {
    e.preventDefault()

    const sobre = document.getElementById('sobre')

    if (sobre.classList.contains("hide")) {
        setTimeout(function(){sobre.hidden = false}, 500)
        sobre.classList.remove("hide");
    } else {
        sobre.classList.add("hide");
        setTimeout(function(){sobre.hidden = true}, 400)
    }
})



/*
 * Função para deixar a primeira letra da palavra em maísculo
 */
function capitalizarPrimeiraLetra(string) {
    if(string != null) {
    return string.charAt(0).toUpperCase() + string.slice(1)
    }
    else {
        return string
    }
}

/*
 * Função que configura a mensagem de sucesso na tela
 */
function setMensagemSucesso(mensagem) {
    const alertaSucesso = document.getElementById('alerta-sucesso')
    
    alertaSucesso.innerHTML = mensagem
    alertaSucesso.hidden = false
    setTimeout(function(){alertaSucesso.hidden = true}, 10000)
}