import Popup from "./Popup.js";
import Table from "./Table.js";

class Compound {
    static get context() {
        let poup_visiable = document
            .querySelector("div.popup")
            .classList
            .contains("visiable");

        if (poup_visiable) {
            return new Popup;
        }

        return new Table(document.querySelector("table.visiable"));
    }
}

export default Compound;