
class Api {
  constructor() {
    this.base = 'https://guselnikov.ivsand.ru/rest';
  }

  request = async (method, options) => {
    const url = this.base + method;
    return fetch(url, {...options, mode: 'cors'});
  }

  rest = async (method, options) => {
    return this.request(method, options)
        .then((data) => data)
  }
}
export default Api;
