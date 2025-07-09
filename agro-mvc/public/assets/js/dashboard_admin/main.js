import Button from "./Button.js";
import Compound from "./Compound.js";
import Listener from "./Listener.js";

Compound.buttons.forEach((button) => {
  switch (button.className) {
    case Button.Switch:
      Listener.bind(button, Compound.changeTable);
      break;
    case Button.Edit:
      Listener.bind(button, Compound.assemblyPopup);
      break;
    case 'unique_item':
      console.log('ola');
      break;
  }
});
