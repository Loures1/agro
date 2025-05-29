import Button from './Button.js'
import Table from './Table.js';
import Poup from './Popup.js';

class Dashboard {
  button_response = new Map([
    ["switch", this.unCoverTable],
    ["edit", this.unCoverPopup],
  ]);

  listerner() {
    Button.buttons.forEach((button) => {
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
    Table.tables.map((table) => {
      if (target == table.className) {
        table.style.display = "block";
      } else {
        table.style.display = "none";
      }
    });
  }

  unCoverPopup(target) {
    let poup = new Poup();
    Table.fields(target).forEach((field) => {
      poup.set(field)
    });
    poup.show()
  }
}

const dash = new Dashboard();
dash.listerner();