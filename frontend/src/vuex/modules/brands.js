import Vue from 'vue'

export default {
    state: {
        brandsList: []
    },
    mutations: {
        UPDATEBRANDLIST (state, data) {
            state.brandsList = data
        }
    },
    actions: {
        getBrands (context) {
            Vue.http.get('marcas').then(response => {
                context.commit('UPDATEBRANDLIST', response.data)
            })
        }
    }
}