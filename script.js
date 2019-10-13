var vm = new Vue({
  el: '#app',
  data: {
    columns: ['id', 'Marca', 'Modelo', 'Ano'],
    marcas: ['Volkswagen', 'FIAT', 'FORD', 'BMW', 'Renault', 'Gurgel', 'Cherry'],
    input : [],
    carros: [],
  },
  mounted() {
    this.update_screen();
  },
  methods: {
    update_screen() {
      axios.get("api/carros").then((r)=>{
        if(r.data=="Installation complete.") {
          alert("Instalado banco de dados...");
          location.reload();
        }
        this.carros = r.data;
      });
    },
    add() {
      if(this.input.marca==undefined)
        alert("Favor preencher a marca");
      else if(this.input.modelo=="")
        alert("Favor preencher a modelo");
      else if(this.input.ano=="")
        alert("Favor preencher a ano");
      else 
      axios.post("api/carros", {"marca":this.input.marca, "modelo":this.input.modelo, "ano":this.input.ano}).then((r)=>{
        this.input.marca=this.input.modelo=this.input.ano="";
        this.update_screen();
      });
    },
    delete_id(id) {
      axios.delete("api/carros/"+id).then((r)=>{
        this.update_screen();
      })
    },
    update_id(key, value, id) {
      axios.put("api/carros/"+id+"?"+key+"="+value).then((r)=> {
        //nothing to do
      });
    }
  }
});