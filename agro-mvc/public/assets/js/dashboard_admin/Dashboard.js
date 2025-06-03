import Table from './Table.js';
import Poup from './Popup.js';

class Dashboard {
  #response = new Map([
    ["switch", this.unCoverTable],
    ["edit", this.unCoverPopup],
    ["close_edit", this.coverPopup],
    ["change_item", this.changeItemFromPopup],
    ["add_item", this.addItemFromPopup]
  ]);

  listen(elements, type_event) {
    Array.from(elements)
      .forEach((button) => button.addEventListener(type_event, (e) => this.action(e)
    ));
  }

  action(event) {
    let button = event.srcElement;
    let response = this.#response.get(button.className);
    response(this, button.value);
  }

  unCoverTable(self, target) {
    Table.tables.map((table) => {
      if (table.classList.contains(target)) {
        table.classList.replace("hidden", "visiable");
      } else {
        table.classList.replace("visiable", "hidden");
      }
    });
  }

  unCoverPopup(self, target) {
    let poup = new Poup();
    Table.fields(target).forEach((field) => poup.set(field));
    poup.show();
    self.listen(document.querySelectorAll(".popup .content button"), "click");
  }

  coverPopup(self) {
    let poup = new Poup();
    poup.close();
  }

  changeItemFromPopup(self) {
    console.log('ola');
  }

  addItemFromPopup(self) {
    console.log('oi');
  }
}

var dash = new Dashboard();
dash.listen(document.querySelectorAll("button"), "click");