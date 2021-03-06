import api from './api';

export default {
  namespaced: true,
  state: {
    items: [],
  },
  getters: {
    items: state => state.items,
    itemsByKey: state => state.items.reduce((res, cur) => {
      res[cur['id']] = cur;
      return res;
    }, {})
  },
  mutations: {
    setItems: (state, items) => {
      state.items = items;
    },
    addItem: (state, item) => {
      state.items.push(item);
    },
    removeItem: (state, idRemove) => {
      state.items = state.items.filter(({ id }) => id !== idRemove);
    },
    updateItem: (state, updateItem) => {
      const index = state.items.findIndex(item => +item.id === +updateItem.id);
      state.items[index] = updateItem;
    }
  },
  actions: {
    fetchItems: async ({ commit }) => {
      const response = await api.loans();
      const items = await response.json();
      await commit('setItems', items)
    },
    fetchFilteredItems: async ({ commit }, {filter_field, filter_id}) => {
      const response = await api.loansFiltered(filter_field, filter_id);
      const items = await response.json();
      await commit('setItems', items)
    },
    removeItem: async ({ commit }, id) => {
      const response = await api.remove( id );
      if (!response.error.error)
        await commit('removeItem', id);
      else
        alert(response.error.error_massage);
    },
    addItem: async ({ commit }, loan) => {
      const response = await api.add(loan);
      if (!response.error.error)
        await commit('addItem', response.item);
      else
        alert(response.error.error_message);
    },
    updateItem: async ({ commit }, loan) => {
      const response = await api.update(loan);
      if (!response.error.error)
        await commit('updateItem', response.item);
      else
        alert(response.error.error_massage);
    }
  },
}
