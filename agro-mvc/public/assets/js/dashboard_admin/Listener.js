import Action from "./Action.js";
import Tag from "./Tag.js";

/**
 * @class
 * @description It defines a reponse for a determined interation.
*/
class Listener {

  /**
  * It listens the element.
  * @static
  * @param {HTMLHtmlElement} element
  * @param {Compound} func
  * @description It relations an element with determined event for exec
  * determined action.
  */
  static bind(element, func) {
    switch (element.tagName) {
      case Tag.Button:
        var action = Action.Click
        break;
    }
    element.addEventListener(action, (e) => func(e));
  }
}

export default Listener;
