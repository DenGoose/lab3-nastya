import { createStore } from 'vuex'
import clients from './clients';
import loans from './loans';
import files from './files';
export default createStore({
  modules: {
    clients,
    loans,
    files,
  },
  state: {},
  mutations: {},
  actions: {},
})
