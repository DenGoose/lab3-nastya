import { createStore } from 'vuex'
import clients from './clients';
import loans from './loans';
export default createStore({
  modules: {
    clients,
    loans,
  },
  state: {},
  mutations: {},
  actions: {},
})
