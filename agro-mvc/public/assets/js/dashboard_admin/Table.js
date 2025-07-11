class Table {
  /**
   * @static It returns all the content within a given row.
   * @param {HTMLButtonElement} button
   * @returns {Array<NodeListOf<HTMLTableCellElement>>}
   * @description It returns all td within a given tr belonging there's a
   * table visible.
  */
  static row(button) {
    let row_data = [
      ...document
        .querySelector(`table.visible tr.${button.value}`)
        .querySelectorAll(`td`)
    ];

    return row_data;
  }

  /**
   * @static It returns the attribute from html tag td.
   * @param {HTMLTableCellElement} td
   * @returns {String|null} attribute
   * @description Even td tag has an attribute. They can to be: name, tel,
   * training, etc...That method returns this attribute.
  */
  static attribute(td) {
    let attribute = [...td.classList]
      .filter((name) => (name != 'many_items' && name != 'unique_item'))
      .shift();

    return attribute;
  }

  /**
   * @static It returns the nodeName.
   * @param {HTMLTableCellElement} td
   * @returns {String} type
   * @description The type can to be neither text or ul.
  */
  static type(td) {
    return td.firstChild.nodeName;
  }

  /**
   * @static It returns the nodeValue or li.
   * @param {HTMLTableCellElement} td
   * @returns {String|Array<NodeList>} content
   * @description The content can to be neither text or ul's lis.
  */
  static content(td) {
    switch (this.type(td)) {
      case '#text': return td.firstChild.nodeValue;
      case 'UL': return [...td.querySelectorAll('ul li')].map((li) => li.textContent);
    }
  }

  /**
   * @static It returns header for label.
   * @param {HTMLTableCellElement} td
   * @returns {String} header
   * @description The header is attribute translate in portuguese with first letter capitalize.
  */
  static header(td) {
    let header = this.attribute(td);
    switch (header) {
      case 'name': return 'Nome';
      case 'mat': return 'Matrícula';
      case 'tel': return 'Telefone';
      case 'email': return 'Email';
      case 'job': return 'Profissão';
      case 'training': return 'Treinamento(s)';
      default: return '[NoTraslate]';
    };
  }

  /**
   * @static It returns the button schema.
   * @param {HTMLTableCellElement} td
   * @returns {String} button_schema
   * @description The button schema can to be neither many items or unique items.
  */
  static button_schema(td) {
    let button_schema = [...td.classList]
      .filter((name) => name == 'many_items' || name == 'unique_item')
      .shift();

    return button_schema;
  }

  /**
   * @static It returns the options of the tag select.
   * @param {Array<Array>} td
   * @returns Array within id and name
   * @description The options are set of the id and name for to assembly the options
   * of the html select.
  */
  static options(td) {
    let options = [...document.querySelectorAll(`table.${this.attribute(td)} tr`)].slice(1);
    options = options.map((tr) => [tr.className, tr.cells[1].innerText]);
    return options;
  }

  static searchByIdentifier(table, pointer) {
    let name = [...document.querySelectorAll(`table.${table} tr.${pointer} td`)];
    return Table.content(name[1]);
  }

  static underlineOriginUniqueItem(area_unique_item) {
    let li = [...area_unique_item.querySelectorAll('ul li')][0];
    li.innerHTML = `<s>${li.textContent}</s>`;
  }

  static addReplaceOriginUniqueItem(area_unique_item, replace_name, replace_pointer) {
    let ul = area_unique_item.querySelector('ul');
    let li = [...ul.querySelectorAll('li')];

    if (li.length == 2) {
      li[1].className = replace_pointer;
      li[1].innerHTML = replace_name;
    } else {
      let new_li = document.createElement('li');
      new_li.className = replace_pointer;
      new_li.textContent = replace_name;
      ul.appendChild(new_li);
    }
  }

  static resetUniqueItem(area_unique_item, origin) {
    let li = [...area_unique_item.querySelectorAll('ul li')];

    if (li.length == 2) {
      li[0].innerHTML = origin;
      li[1].remove();
    } else {
      li[0].innerHTML = origin;
    }
  }

  static addManyItems(area_many_items, replace_name, replace_pointer) {
    let ul = area_many_items.querySelector('ul');
    let new_li = document.createElement('li');
    let new_input = document.createElement('input');
    new_input.className = 'removeManyItems';
    new_input.type = 'checkbox';
    new_li.appendChild(new_input);
    new_li.className = replace_pointer;
    new_li.insertAdjacentText('beforeend', replace_name);
    ul.appendChild(new_li);
    return new_input;
  }
}

export default Table;
