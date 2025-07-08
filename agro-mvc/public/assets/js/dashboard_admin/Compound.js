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

  static #uncoverPopup() {
    document.querySelector('div.popup').classList.replace("hidden", "visible");
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
            Table.button_schema(td),
            Table.header(td),
            Table.content(td),
            Table.options(td),
          );
      }
    });

    let popup = new Popup();
    content.forEach((data) => popup.defineContent(data));
    Compound.#uncoverPopup();
  }
}

export default Compound;
