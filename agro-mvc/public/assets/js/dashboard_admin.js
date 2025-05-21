class Dashboard {
  constructor() {
    this.buttons = Array.from(document.getElementsByTagName('button'));
  }

  listenButtons() {
    const content = new Content();
    
  }

  changeTable(table) {
    const content = new Content();
    content.tables.map((_) => {
      if (table == _.className) {
        _.style.display = "block"
      } else {
        _.style.display = "none"
      }
    })
  }
}

class Content {
  constructor() {
    this.tables = Array.from(document.getElementsByTagName('table'))
  }

  getTable(target) {
    return this.tables.filter((table) => table.className == target).shift()
  }

}

const dash = new Dashboard()
dash.listenButtons()