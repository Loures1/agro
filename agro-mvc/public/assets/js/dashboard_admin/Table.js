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
      .filter((name) => (name != 'many_items') || name != 'unique_items')
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
        case 'UL': return [...td.querySelectorAll('ul li')];
    }
  }

  /**
   * @static It returns header for label.
   * @param {HTMLTableCellElement} td
   * @returns {String} header
   * @description The header is attribute with the first letter capitalize. 
  */
  static header(td) {
    let header = this.attribute(td);
    console.log(header);
    switch (header) {
        case 'name': return 'Nome';
        case 'mat': return 'Matricula';
        case 'tel': return 'Telefone';
        case 'email': return 'Email';
        case 'job': return 'Profissão';
        case 'training': return 'Treinamento(s)';
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
    let options = [];
    [...document.querySelectorAll(`table.${this.attribute(td)}`)]
      .forEach((tr) => options.push([...tr.querySelectorAll('td')].slice(0, 1)));

    return options;
  }
}

export default Table;