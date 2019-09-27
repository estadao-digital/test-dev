export default {
    state: {
        carros: [],
        marcas: []
    },
    getters: {
        carros(state){
            return state.carros;
        },
        marcas(state){
            return state.marcas;
        }
    },
    mutations: {
        atualizarListagemCarros(state, payload){
            state.carros = payload;
        },
        atualizarListagemMarcas(state, payload){
            state.marcas = payload;
        }
    },
    actions: {
        getCarros(context){
            axios.get('/api/carros')
                .then((response) => {
                    context.commit('atualizarListagemCarros', response.data);
                });
        },
        getMarcas(context){
            axios.get('/api/marcas')
                .then((response) => {
                    context.commit('atualizarListagemMarcas', response.data);
                });
        }
    }
}
