import Table from './Table.js';
import Poup from './Popup.js';

class Dashboard {
  #response = new Map([
    ["switch", this.#unCoverTable],
    ["edit", this.#unCoverPopup],
    ["close_edit", this.#coverPopup],
    ["change_item", this.#changeItemFromPopup],
    ["add_item", this.#addItemFromPopup],
    ["checkbox_item", this.#changeCheckBox]
  ]);

  listen(elements, type_event) {
    Array.from(elements)
      .forEach((button) => button.addEventListener(
        type_event, (e) => this.#action(e)
      ));
  }

  #action(event) {
    let response = this.#response.get(event.srcElement.className);
    response(this, event);
  }

  #unCoverTable(self, event) {
    let target = event.srcElement.value;
    Table.tables.map((table) => {
      if (table.classList.contains(target)) {
        table.classList.replace("hidden", "visiable");
      } else {
        table.classList.replace("visiable", "hidden");
      }
    });
  }

  #unCoverPopup(self, event) {
    let target = event.srcElement.value;
    let poup = new Poup();
    Table.fields(target).forEach((field) => poup.set(field));
    poup.show();
    self.listen(document.querySelectorAll(".popup .content button"), "click");
    self.listen(document.querySelectorAll(".popup .content input[type=\"checkbox\"]"), "change");
  }

  #coverPopup(self) {
    let poup = new Poup();
    poup.close();
  }

  #changeItemFromPopup(self) {
    console.log('ola');
  }

  #addItemFromPopup(self) {
    console.log('oi');
  }

  #changeCheckBox(self, event) {
    let item = event.srcElement;
    let title = item.parentElement.querySelector("p");
    if (item.checked) {
      title.innerHTML = `<s>${title.innerHTML}</s>`;
    } else {
      title.innerHTML = title.innerHTML.match(/(?<=<s>)[\w\s\d-()]+(?=<\/s>)/g);
    }
  }
}

var dash = new Dashboard();
dash.listen(document.querySelectorAll("button"), "click");
