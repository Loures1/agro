class Popup {
  #content;
  constructor() {
    this.#content = '';
  }
  /**
   * @param {String} content
  */
  defineContent(content) {
    this.#content += content;
  }

  get content() {
    return this.#content;
  }

  static text(attribute, header, value) {
    return `
      <label class="${attribute}">
        ${header}:
        <input type="text" placeholder="${value}"><br>
      </label>`;
  }

  static list(attribute, button_schema, header, list_unorder, options) {
    let value_button;

    switch (button_schema) {
      case 'many_items':
        value_button = 'Adicionar';
        list_unorder = list_unorder.map((li) => this.#liCheckbox(li));
        break;
      case 'unique_item':
        value_button = 'Trocar';
        list_unorder = list_unorder.map((li) => this.#li(li));
        break;
    };

    list_unorder = list_unorder
      .toString()
      .replaceAll(/,/g, '');

    options = options
      .map((option) => this.#options(...option))
      .toString()
      .replaceAll(/,/g, '');

    return `
      <label class="${button_schema} ${attribute}">
        ${header}:
          <ul>
            ${list_unorder}
          </ul><br>
          <select>
            ${options}
          </select>
          <button class="${button_schema}">${value_button}</button><br>
      </label>`;
  }

  static #options(id, value) {
    return `<option value="${id}">${value}</option>`;
  }

  static #liCheckbox(value) {
    return `<li class="origin"><input class="removeManyItems" type="checkbox">${value}</li>`;
  }

  static #li(value) {
    return `<li class="origin">${value}</li>`;
  }
};

export default Popup;
