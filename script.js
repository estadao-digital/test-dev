var vm = new Vue({
  el: '#app',
  data: {
    columns: ['id', 'Marca', 'Modelo', 'Ano'],
    input : [],
    carros: [],
  },
  mounted() {
    this.update_screen();
  },
  methods: {
    update_screen() {
      axios.get("api/carros").then((r)=>{
        this.carros = r.data;
      });
    },
    add() {
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