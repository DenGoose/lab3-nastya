export const fetchItems = ( store ) => {
  const { dispatch } = store;
  dispatch('loans/fetchItems');
};

export const fetchSortedItems = ( store ) => {
  const { dispatch } = store;
  dispatch('loans/fetchSortedItems');
};

export const selectSortItems = ( store, client_id = 0 ) => {
  const { getters } = store;
  return  getters['loans/items'];
}

export const selectItems = ( store) => {
  const { getters } = store;
  return  getters['loans/items'];
}

export const removeItem = ( store, id ) => {
  const { dispatch } = store;
  dispatch('loans/removeItem', id);
}

export const addItem = ( store, { photo, loan_purpose, manager_comment, loan_amount, id_client } ) => {
  const { dispatch } = store;
  dispatch('loans/addItem', { photo, loan_purpose, manager_comment, loan_amount, id_client });
}

export const updateItem = ( store, { id, photo, loan_purpose, manager_comment, loan_amount, id_client }) => {
  const { dispatch } = store;
  dispatch('loans/updateItem', { id, photo, loan_purpose, manager_comment, loan_amount, id_client });
}

export const selectItemById = (store, id) => {
  const { getters } = store;
  return getters['loans/itemsByKey'][id] || {};
}
