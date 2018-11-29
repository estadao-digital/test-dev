import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        carros: []
    },
    mutations: {
        ["SET_CARROS"](state, data) {
            state.carros = data
        },
        ["NOVO_CARRO"](state, data) {
            state.carros.push(data)
        },
        ["ATUALIZAR_CARRO"](state, data) {
            var index = state.carros.findIndex(function(value) {
                return value.id === data.id;
            })
            state.carros.splice(index, 1)
            state.carros.push(data)
        },
        ["DELETAR_CARRO"](state, data) {
            var index = state.carros.findIndex(function(value) {
                return value.id === data.id;
            })
            state.carros.splice(index, 1)

        }
    },
    actions: {
        async setCarros({commit}) {
            const response = await axios.get('carros')
            commit("SET_CARROS", response.data)
        },
        async novoCarro({commit}, carro) {
            const response = await axios.post('carros', carro)
            commit("NOVO_CARRO", response.data)
        },
        async atualizarCarro({commit}, carro) {
            const response = await axios.put('carros/' + carro.id, carro)
            commit("ATUALIZAR_CARRO", response.data)
        },
        async deletarCarro({commit}, carro) {
            await axios.delete('carros/' + carro.id, carro)
            commit("DELETAR_CARRO", carro)
        }

    },
    getters: {
        carros: state => {
            return state.carros
        }
    },
})
