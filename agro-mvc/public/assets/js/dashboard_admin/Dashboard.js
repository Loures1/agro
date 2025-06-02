import Listerner from './Listener.js'
import Table from './Table.js';
import Poup from './Popup.js';

class Dashboard {
  constructor() {
    this.listener = new Listerner();
  }

  button_response = new Map([
    ["switch", this.unCoverTable],
    ["edit", this.unCoverPopup],
    ["close_edit", this.coverPopup]
  ]);

  listerner() {
    Array.from(document.querySelectorAll("button")).forEach((button) => {
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
      if (table.classList.contains(target)) {
        table.classList.replace("hidden", "visiable");
      } else {
        table.classList.replace("visiable", "hidden");
      }
    });
  }

  unCoverPopup(target) {
    let poup = new Poup();
    Table.fields(target).forEach((field) => {
      poup.set(field)
    });
    poup.show();
  }

  coverPopup() {
    let poup = new Poup();
    poup.close();
  }
}

const dash = new Dashboard();
dash.listerner();