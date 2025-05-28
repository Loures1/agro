import Content from './content.js'

class Dashboard {
  button_response = new Map([
    ["switch", this.unCoverTable],
    ["edit", this.unCoverPopup],
  ]); 

  listerner() {
    Content.buttons.forEach((button) => {
      button.addEventListener("click", (e) => {
        this.action(e);
      });
    });
  }

  action(event) {
    let button = event.srcElement;
    let response = this.button_response.get(button.className);
    response(button.value);
  }

  unCoverTable(target) {
    Content.tables.map((table) => {
      if (target == table.className) {
        table.style.display = "block";
      } else {
        table.style.display = "none";
      }
    });
  }

  unCoverPopup() {
  }
}

const dash = new Dashboard();
dash.listerner()