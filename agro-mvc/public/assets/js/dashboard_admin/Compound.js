/**
 * @class
 * @description It to give the states and to handle the elements of the screen.
*/
class Compound {
  /**
   * It returns context's buttons.
   * @static
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

    return [...document.querySelectorAll("button")]
  }

  /**
   * It changes the context.
   * @static
   * @param {PointerEvent} event - It receives event when button is click.
   * @description It defines the visible table for hidden and defines the hidden
   * target table for visible.
  */
  static changeContext(event) {
    document
      .querySelector("table.visible")
      .classList
      .replace("visible", "hidden");

    document
      .querySelector(`table.${event.target.value}`)
      .classList
      .replace("hidden", "visible");
  }
}

export default Compound;
