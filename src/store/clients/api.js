import Api from '@/api/index';

class Clients extends Api {

  /**
   * Вернет список всех клиентов
   * @returns {Promise<Response>}
   */
  clients = () => this.rest('/clients/list.json');

  /**
   * Удалит клиента по id
   * @param id
   * @returns {Promise<*>}
   */
  remove = ( id ) => this.rest('/clients/delete-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify({ id }),
  }).then(() => id) // then - заглушка, пока метод ничего не возвращает

  /**
   * Создаст новую запись в таблице
   * @param clients объект клиента, взятый из FormClients
   * @returns {Promise<Response>}
   */
  add = ( clients ) => this.rest('/clients/add-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(clients),
  }).then(() => ({...clients, id: new Date().getTime()})) // then - заглушка, пока метод ничего не возвращает

  /**
   * Отправит измененную запись
   * @param clients объект клиента, взятый из FormClients
   * @returns {Promise<*>}
   */
  update = ( clients ) => this.rest('/clients/update-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(clients),
  }).then(() => clients) // then - заглушка, пока метод ничего не возвращает

}

export default new Clients();
