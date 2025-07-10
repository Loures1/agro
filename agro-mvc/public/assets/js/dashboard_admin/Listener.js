import Action from "./Action.js";
import Tag from "./Tag.js";

/**
 * @class
 * @description It defines a reponse for a determined interation.
*/
class Listener {

  /**
  * @static It listens the element.
  * @param {HTMLHtmlElement} element
  * @param {Compound} func
  * @description It relations an element with determined event for exec
  * determined action.
  */
  static bind(element, func) {
    let action;
    switch (element.tagName) {
      case Tag.Button:
        action = Action.Click;
        break;
      case Tag.CheckBox:
        action = Action.Change;
        break;
    }
    element.addEventListener(action, (e) => func(e));
  }
}

export default Listener;
