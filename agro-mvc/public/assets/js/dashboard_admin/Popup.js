import Table from "./Table.js";

class Poup {
  constructor() {
    this.element = document.querySelector("div.popup");
    this.content = "";
  }

  #formText = `
    {header}:
      <input type="text" placeholder="{value}">
    <br>`;

  #formUl = `
    <div class="{button_schema}">
      <label> {header}:
        {list_unorder}
        <select>
          {options}
        </select>
        {button}
      </label>
    </div>`;

  set(item) {
    let type = item.firstChild.nodeName;

    let field = Array.from(item.classList)
      .filter((className) => {
        return className != "unique_item" || className != "many_items"
      })
      .shift();

    if (type == "#text") {
      this.content += this.#formText.replace(/{header}|{value}/g, (match) => {
        switch (match) {
          case "{header}": return Table.header(field);
          case "{value}": return item.innerHTML;
        };
      });
    }
    if (type == "UL") {
      let selecters = Table.tables
        .filter((selecter) => selecter.classList.contains(field))
        .shift()
        .querySelectorAll("tr");

      let button_schema = Array.from(item.classList)
        .filter((button_schema) => {
          return button_schema == "unique_item" || button_schema == "many_items";
        })
        .shift();

      let list_unorder = item.innerHTML.replace(
        /(?<=<li>)[\w\s()\d-]+(?=<\/li>)/g, (match) => {
          if (button_schema == "many_items") {
            return `
              <label>
                <input type="checkbox" class="checkbox_item">
                <p>${match}</p>
              </label>`;
          } else {
            return match;
          }
        }
      );

      let button = "";
      if (button_schema == "many_items") {
        button = `<button class="add_item">Adicionar</button>`;
      } else {
        button = `<button class="change_item">Trocar</button>`
      }

      let options = "";
      Array.from(selecters)
        .filter((selecter) => selecter.className)
        .forEach((selecter) => {
          options += `
            <option values="${selecter.className}">
              ${selecter.querySelector("td.name").innerHTML}
            </option>`;
        });
      this.content += this.#formUl.replace(
        /{header}|{list_unorder}|{options}|{button_schema}|{button}/g, (match) => {
          switch (match) {
            case "{header}": return Table.header(field);
            case "{list_unorder}": return list_unorder;
            case "{options}": return options;
            case "{button_schema}": return button_schema;
            case "{button}": return button;
          };
        }); ''
    }
  }

  show() {
    this.element.querySelector("div.content").innerHTML = this.content;
    this.element.classList.replace("hidden", "visiable");
  }

  close() {
    this.element.querySelector("div.content").innerHTML = this.content;
    this.element.classList.replace("visiable", "hidden");
  }
}

export default Poup;
