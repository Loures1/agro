import Table from "./Table.js";

class Poup {
  constructor() {
    this.content = "";
  }

  set(item) {
    let type = item.firstChild.nodeName;
    if (type == "#text") {
      this.content += `
        <label>${Table.header(item.className)}:
        <input type="text" placeholder="${item.innerHTML}">
        </label><br>`;
    }
    if (type == "UL") {
      this.content += `<div>`;
      this.content += `<label> ${Table.header(item.className)}:`
      this.content += item.innerHTML;
      let options = Table.tables
        .filter((table) => table.className == item.className)
        .shift()
        .querySelectorAll("tr");
      this.content += `<select>`;
      Array.from(options)
        .filter((option) => option.className)
        .forEach((option) => {
          this.content += `
            <option values="${option.className}">
              ${option.querySelector("td.name").innerHTML}
            </option>`;
        });
      this.content += `</select>`;
      this.content += `</label>`
      this.content += `</div>`;
    }
  }

  show() {
    let poup = document.querySelector("dialog");
    poup.querySelector("div.content").innerHTML = this.content;
    poup.showModal();
  }
}

export default Poup;
