class Table {
  static tables = Array.from(document.querySelectorAll("table"));

  static fields(target) {
    return Array.from(document.querySelectorAll(`.${target}`)
      .item(0)
      .children
    ).filter((field) => field.className);
  }

  static header(field) {
    let headers = this.tables
      .filter((table) => table.classList.contains("visiable"))
      .shift()
      .querySelectorAll("tr > th");

    return Array.from(headers)
      .filter((header) => header.className == field)
      .shift()
      .innerHTML;
  }
}

export default Table;
