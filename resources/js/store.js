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
        },
        removeCarro(state, payload){
            let index = state.carros.findIndex(item => item.id === payload);
            state.carros.splice(index, 1);
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
        },
        deleteCarro(context, id){
            axios.delete(`api/carros/${id}`)
                .then(() => context.commit('removeCarro', id));

        }
    }
}
