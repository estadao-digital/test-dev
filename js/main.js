function atualiza_tabela(){

}

function submit_form(event){
    event.preventDefault();
    fetch('test-dev/carros',{
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({a: 1, b: 'Textual content'})
      }).then((data) => {
    console.log('oi')
  })
  .catch((error) => console.error('Whoops! Erro:', error.message || error))

}

function update_data(){

}
function destroy_data(){
    
}
function open_modal(modal,button,id){
    
}
