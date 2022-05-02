export const fetchLoansItems = ( store ) => {
  const { dispatch } = store;
  dispatch('loans/fetchItems');
};

export const fetchLoansFilteredItems = ( store, filter_field, filter_id ) => {
  const { dispatch } = store;
  return dispatch('loans/fetchFilteredItems', {filter_field: filter_field, filter_id: filter_id});
};

export const selectLoansItems = ( store) => {
  const { getters } = store;
  return  getters['loans/items'];
}

export const removeLoansItem = ( store, id ) => {
  const { dispatch } = store;
  return dispatch('loans/removeItem', id);
}

export const addLoansItem = async (store, loan) => {
  const {dispatch} = store;
  return await dispatch('loans/addItem', loan);
}

export const updateLoansItem = ( store, loan) => {
  const { dispatch } = store;
  return dispatch('loans/updateItem', loan);
}

export const selectLoansItemById = (store, id) => {
  const { getters } = store;
  return getters['loans/itemsByKey'][id] || {};
}
