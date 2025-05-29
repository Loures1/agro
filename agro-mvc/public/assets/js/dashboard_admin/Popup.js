import Table from "./Table.js";

class Poup {
  constructor() {
    this.content = "";
  }

  #formText = `
    <label>{header}:
      <input type="text" placeholder="{value}">
    </label><br>`;

  #formUl = `
    <div>
      <label> {header}:
        {list_unorder}
        <select>
          {options}
        </select>
      </label>
    </div>`;

  set(item) {
    let type = item.firstChild.nodeName;
    if (type == "#text") {
      this.content += this.#formText.replace(/{header}|{value}/g, (match) => {
        switch (match) {
          case "{header}": return Table.header(item.className);
          case "{value}": return item.innerHTML;
        };
      });
    }
    if (type == "UL") {
      let selecters = Table.tables
        .filter((selecter) => selecter.className == item.className)
        .shift()
        .querySelectorAll("tr");

      let options = "";
      Array.from(selecters)
        .filter((selecter) => selecter.className)
        .forEach((selecter) => {
          options += `
            <option values="${selecter.className}'>
              ${selecter.querySelector("td.name").innerHTML}
            </option>`;
        });
      this.content += this.#formUl.replace(
        /{header}|{list_unorder}|{options}/g, (match) => {
          switch (match) {
            case "{header}": return Table.header(item.className);
            case "{list_unorder}": return item.innerHTML;
            case "{options}": return options;
          };
        });
    }
  }

  show() {
    let poup = document.querySelector("dialog");
    poup.querySelector("div.content").innerHTML = this.content;
    poup.showModal();
  }
}

export default Poup;