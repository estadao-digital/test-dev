import Vue from 'vue'

export default {
    state: {
        carsList: [],
        carsView: {}
    },
    mutations: {
        UPDATECARLIST (state, data) {
          state.carsList = data
        },
        UPDATECARVIEW (state, data) {
            state.carsView = data
        }
    },
    actions: {
        getCars (context) {
            Vue.http.get('carros').then(response => {
                context.commit('UPDATECARLIST', response.data)
            })
        },
        getCar (context, id) {            
            Vue.http.get('carros/' + id).then(response => {
                context.commit('UPDATECARVIEW', response.data)
            })
        },
        newCar (context, data) {
            Vue.http.post('carros', data).then(response => {
                context.commit('UPDATECARLIST', response.data)
            })
        },
        updateCar (context, params) {
            Vue.http.put('carros/' + params.id, params.data).then(response => {
                context.commit('UPDATECARLIST', response.data)
            })
        },
        removeCar (context, id) {
            Vue.http.delete('carros/' + id).then(response => {
                context.commit('UPDATECARLIST', response.data)
            })
        }
    }
}