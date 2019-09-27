export default {
    state: {
        carros: []
    },
    getters: {
        carros(state){
            return state.carros;
        }
    },
    mutations: {
        atualizarListagemCarros(state, payload){
            state.carros = payload;
        }
    },
    actions: {
        getCarros(context){
            axios.get('/api/carros')
                .then((response) => {
                    context.commit('atualizarListagemCarros', response.data);
                });
        }
    }
}
