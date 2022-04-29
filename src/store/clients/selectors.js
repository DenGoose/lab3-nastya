export const fetchItems = (store) => {
  const { dispatch } = store;
  dispatch('clients/fetchItems');
};

export const selectItems = (store) => {
  const { getters } = store;
  return getters['clients/items'];
}

export const removeItem = (store, id) => {
  const { dispatch } = store;
  dispatch('clients/removeItem', id);
}

export const addItem = (store, { name }) => {
  const { dispatch } = store;
  dispatch('clients/addItem', { name });
}

export const updateItem = (store, { id, name }) => {
  const { dispatch } = store;
  dispatch('clients/updateItem', { id, name });
}

export const selectItemById = (store, id) => {
  const { getters } = store;
  return getters['clients/itemsByKey'][id] || {};
}
