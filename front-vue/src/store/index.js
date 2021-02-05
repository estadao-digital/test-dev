import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const state = {
  title: undefined,
  load: false,
  toast: { show: false, message: null, title: null, variant: 'info' },
  usuario: undefined
}

const types = {
  SET_TITLE: 'SET_TITLE',
  SET_LOAD: 'SET_LOAD',
  SET_TOAST: 'SET_TOAST',
  SET_USUARIO: 'SET_USUARIO'
}

const mutations = {
  [types.SET_TITLE]: (state, { title }) => {
    state.title = title
  },
  [types.SET_LOAD]: (state, { load }) => {
    state.load = load
  },
  [types.SET_TOAST]: (state, { toast }) => {
    state.toast = toast
  },
  [types.SET_USUARIO]: (state, { usuario }) => {
    state.usuario = usuario
  }
}

const actions = {
  setTitle: ({ commit }, payload) => {
    commit(types.SET_TITLE, payload)
  },
  setLoad: ({ commit }, payload) => {
    // console.log('payload: ', payload)
    commit(types.SET_LOAD, payload)
  },
  setToast: ({ commit }, payload) => {
    // console.log('payload: ', payload)
    commit(types.SET_TOAST, payload)
  },
  setUsuario: ({ commit }, payload) => {
    commit(types.SET_USUARIO, payload)
  }
}

export default new Vuex.Store({
  state,
  mutations,
  actions
})
