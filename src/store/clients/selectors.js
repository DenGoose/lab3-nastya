export const fetchClientsItems = (store) => {
  const { dispatch } = store;
  dispatch('clients/fetchItems');
};

export const fetchClientsFilteredItems = (store, filter_field, filter_id) => {
  const { dispatch } = store;
  dispatch('clients/fetchFilteredItems', filter_field, filter_id);
};

export const selectClientsItems = (store) => {
  const { getters } = store;
  return getters['clients/items'];
}

export const removeClientsItem = (store, id) => {
  const { dispatch } = store;
  dispatch('clients/removeItem', id);
}

export const addClientsItem = (store, { name }) => {
  const { dispatch } = store;
  dispatch('clients/addItem', { name });
}

export const updateClientsItem = (store, { id, name }) => {
  const { dispatch } = store;
  dispatch('clients/updateItem', { id, name });
}

export const selectClientsItemById = (store, id) => {
  const { getters } = store;
  return getters['clients/itemsByKey'][id] || {};
}
