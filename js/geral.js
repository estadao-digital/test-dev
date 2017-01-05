
// Confirma se registro deve ser deletado
function confirmacao(id) {
     var resposta = confirm("Deseja remover esse registro?");
 
     if (resposta == true) {
          window.location.href = "index.php?acao=deletar&id="+id;
     }
}