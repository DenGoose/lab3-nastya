import Api from '@/api/index';

class Loans extends Api {

  /**
   * Вернет список всех кредитов
   * @returns {Promise<Response>}
   */
  loans = () => this.rest('/loans/get-list.json', {
    method: 'GET',
    'Content-Type': 'application/json',
  });

  loansFiltered = (filter_field, filter_id) => this.rest(`/loans/get-list.json?filter[${filter_field}]=${filter_id}`, {
    method: 'GET',
    'Content-Type': 'application/json',
  });
  /**
   * Удалит кредит по id
   * @param id
   * @returns {Promise<*>}
   */
  remove = ( id ) => this.rest('/loans/delete.json', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify({ id }),
  }).then((response) => response.json()).then((resJson) => resJson)

  /**
   * Создаст новую запись в таблице
   * @param loan объект кредита, взятый из FormLoans
   * @returns {Promise<Response>}
   */
  add = ( loan ) => this.rest('/loans/add.json', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(loan),
  }).then((response) => response.json()).then((resJson) => resJson)

  /**
   * Отправит измененную запись
   * @param loan объект кредита, взятый из FormLoans
   * @returns {Promise<*>}
   */
  update = ( loan ) => this.rest('/loans/update.json', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(loan),
  }).then((response) => response.json()).then((resJson) => resJson)

}

export default new Loans();
