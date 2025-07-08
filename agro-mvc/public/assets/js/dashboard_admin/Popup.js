class Popup {
  #content = null;

  /**
   * @param {String} content
  */
  set defineContent(content) {
    this.#content += content;
  }

  static text(attribute, header, value) {
    return `
      <label class="${attribute}">
        ${header}:
        <input type="text" placeholder="${value}"><br>
      </label>`;
  }

  static list(button_schema, header, list_unorder, options) {
    let value_button;
    switch (button_schema) {
      case 'many_items':
        value_button = 'Adicionar';
        break;
      case 'unique_items':
        value_button = 'Trocar';
        break;
    };
    options = options.map((option) => this.#options(...option));
    return `
        <div class="${button_schema}">
            <label> ${header}:
                ${list_unorder}
                <select>
                    ${options}
                </select>
                <button class="${button_schema}">${value_button}</button>
            </label>
        </div>`;
  }

  static #options(id, value) {
    return `<option value="${id}">${value}</option>`;
  }
};

export default Popup;
