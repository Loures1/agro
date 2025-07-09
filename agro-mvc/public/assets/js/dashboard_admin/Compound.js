import Listener from "./Listener.js";
import Popup from "./Popup.js";
import Table from "./Table.js";

/**
 * @class
 * @description It to give the states and to handle the elements of the screen.
*/
class Compound {
  /**
   * @static It returns context's buttons.
   * @param {null} null
   * @returns {Array<NodeList>} It returns either main_buttons div's buttons and
   * table's buttons or popup's buttons.
   * @description If popup is visible it returns the your buttons. If popup isn't
   * visible it returns the table visible's buttons.
  */
  static get buttons() {
    let popup_visiable = document
      .querySelector("div.popup")
      .classList
      .contains("visible");

    if (popup_visiable) {
      return [...document.querySelectorAll("div.popup button")];
    }

    return [...document.querySelectorAll("button")];
  }

  /**
   * It changes table.
   * @static
   * @param {PointerEvent} event - It's event when a button is click.
   * @description It defines the visible table for hidden and defines the hidden
   * target table for visible.
  */
  static changeTable(event) {
    document
      .querySelector("table.visible")
      .classList
      .replace("visible", "hidden");

    document
      .querySelector(`table.${event.target.value}`)
      .classList
      .replace("hidden", "visible");
  }

  static #uncoverPopup(content) {
    let popup = document.querySelector('div.popup');
    popup.querySelector('div.content').innerHTML = content;
    popup.classList.replace("hidden", "visible");

    let buttons = popup.querySelectorAll('button');
    buttons.forEach((button) => {
      switch (button.className) {
        case 'unique_item':
          Listener.bind(button, Compound.changeUniqueItem);
          break;
      }
    })
  }

  static assemblyPopup(event) {
    let content = Table
      .row(event.target)
      .filter((td) => (td.className));

    content = content.map((td) => {
      switch (Table.type(td)) {
        case '#text':
          return Popup.text(
            Table.attribute(td),
            Table.header(td),
            Table.content(td)
          );
        case 'UL':
          return Popup.list(
            Table.attribute(td),
            Table.button_schema(td),
            Table.header(td),
            Table.content(td),
            Table.options(td)
          );
      }
    });

    let popup = new Popup();
    content.forEach((data) => popup.defineContent(data));
    Compound.#uncoverPopup(popup.content);
  }

  static changeUniqueItem(event) {
    let area_unique_item = event.srcElement.parentNode;
    let origin = area_unique_item.querySelector("ul li").textContent;
    let target = Table.attribute(area_unique_item);
    let id = area_unique_item
      .querySelector('select')
      .value;
    let replace_name = Table.searchContentRowByTableNameId(target, id);

    if (origin == replace_name) {
      Table.resetUniqueItem(area_unique_item, origin);
    } else {
      let replace_pointer = target + '_' + id;
      Table.underlineOriginUniqueItem(area_unique_item);
      Table.addReplaceOriginUniqueItem(area_unique_item, replace_name, replace_pointer);
    }
  }
}

export default Compound;
