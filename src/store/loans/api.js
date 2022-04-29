import Api from '@/api/index';

class Loans extends Api {

  /**
   * Вернет список всех кредитов
   * @returns {Promise<Response>}
   */
  loans = () => this.rest('/loans/list.json');
  loansSorted = () => this.rest('/loans/sorted-list.json');

  /**
   * Удалит кредит по id
   * @param id
   * @returns {Promise<*>}
   */
  remove = ( id ) => this.rest('/loans/delete-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify({ id }),
  }).then(() => id) // then - заглушка, пока метод ничего не возвращает

  /**
   * Создаст новую запись в таблице
   * @param loans объект кредита, взятый из FormLoans
   * @returns {Promise<Response>}
   */
  add = ( loans ) => this.rest('loans/add-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(loans),
  }).then(() => ({...loans, id: new Date().getTime()})) // then - заглушка, пока метод ничего не возвращает

  /**
   * Отправит измененную запись
   * @param loans объект кредита, взятый из FormLoans
   * @returns {Promise<*>}
   */
  update = ( loans ) => this.rest('loans/update-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(loans),
  }).then(() => loans) // then - заглушка, пока метод ничего не возвращает

}

export default new Loans();
