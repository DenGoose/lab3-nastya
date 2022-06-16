import Api from '@/api/index';

class Clients extends Api {

  /**
   * Вернет список всех клиентов
   * @returns {Promise<Response>}
   */
  clients = () => this.rest('/clients/get-list.json', {
    method: 'GET',
    'Content-Type': 'application/json',
  });

  clientsFiltered = (filter_field, filter_id) => this.rest(`/clients/get-list.json?filter[${filter_field}]=${filter_id}`, {
    method: 'GET',
    'Content-Type': 'application/json',
  });

  /**
   * Удалит клиента по id
   * @param id
   * @returns {Promise<*>}
   */
  remove = ( id ) => this.rest('/clients/delete.json', {
      method: 'POST',
      'Content-Type': 'application/json',
      body: JSON.stringify({id}),
    }).then((response) => response.json()).then((resJson) => resJson)

  /**
   * Создаст новую запись в таблице
   * @param name объект клиента, взятый из FormClients
   * @returns {Promise<Response>}
   */
  add = ( name ) => this.rest('/clients/add.json', {
      method: 'POST',
      'Content-Type': 'application/json',
      body: JSON.stringify({'id': 0, ...name}),
  }).then((response) => response.json()).then((resJson) => resJson)

  /**
   * Отправит измененную запись
   * @param client объект клиента, взятый из FormClients
   * @returns {Promise<*>}
   */
  update = ( client ) => this.rest('/clients/update.json', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(client),
  }).then((response) => response.json()).then((resJson) => resJson)

}

export default new Clients();
