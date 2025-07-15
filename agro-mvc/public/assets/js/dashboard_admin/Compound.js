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
    let popup = document.querySelector("dialog.popup")

    if (popup.open) {
      return [
        ...document
          .querySelector("dialog.popup")
          .querySelectorAll("button, input[type=\"checkbox\"]")
      ];
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
    let popup = document.querySelector('dialog.popup');
    popup.querySelector('div.content').innerHTML = content;
    popup.showModal();

    Compound.buttons.forEach((button) => {
      switch (button.className) {
        case 'unique_item':
          Listener.bind(button, Compound.changeUniqueItem);
          break;
        case 'many_items':
          Listener.bind(button, Compound.addManyItems);
          break;
        case 'removeManyItems':
          Listener.bind(button, Compound.removeManyItems);
          break;
        case 'close_edit':
          Listener.bind(button, Compound.coverPopup);
          break;
        case 'save':
          Listener.bind(button, Compound.saveRegister);
          break;
      }
    })
  }

  static saveRegister(event) {
    let content = event.srcElement.parentNode.querySelector('.content');
    let tds = Table.header_row().map((header) => {
      let td = document.createElement('td');
      if (!header.className) { return td; }
      let label = content.querySelector(`label.${header.className.replace(/\s/g, '.')}`);
      td.className = label.className;

      if (td.classList.contains('unique_item') && !td.classList.contains('many_items')) {
        let ul = label.querySelector('ul');
        Array.from(ul.querySelectorAll('li')).forEach((li) => {
          if (li.querySelector('s')) { li.remove(); }
        });
        td.textContent = ul.textContent;
      }
      if (!td.classList.contains('unique_item') && td.classList.contains('many_items')) {
        let ul = label.querySelector('ul');
        Array.from(ul.querySelectorAll('li')).forEach((li) => {
          li.querySelector('input').remove();
          if (li.querySelector('s')) { li.remove(); }
        });

        td.textContent = ul.textContent;
      }
      if (!td.classList.contains('unique_item') && !td.classList.contains('many_items')) {
        let input = label.querySelector('input');
        td.textContent = input.value ? input.value : input.placeholder;
      }

      return td;
    });

    let tr = document.createElement('tr');
  }

  static assemblyPopupByCreate() {
    let content = Table
      .header_row()
      .filter((header) => (header.className));

    content = content.map((td) => {
      if (td.classList.contains('many_items') || td.classList.contains('unique_item')) {
        return Popup.list(
          Table.attribute(td),
          Table.button_schema(td),
          Table.header(td),
          '',
          Table.options(td)
        );
      }
      else {
        return Popup.text(
          Table.attribute(td),
          Table.header(td),
          ''
        );
      }
    });

    let popup = new Popup();
    content.forEach((data) => popup.defineContent(data));
    Compound.#uncoverPopup(popup.content);

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
    let origin = area_unique_item.querySelector("ul li.origin");
    if (origin != null) {
      origin = origin.textContent;
    } else {
      origin = '';
    }
    let replace_table = Table.attribute(area_unique_item);
    let replace_pointer = area_unique_item.querySelector('select').value;
    let replace_name = Table.searchByIdentifier(replace_table, replace_pointer);

    if (origin == replace_name && origin != '') {
      Table.resetUniqueItem(area_unique_item, origin);
    }
    if (origin != replace_name && origin != '') {
      Table.underlineOriginUniqueItem(area_unique_item);
      Table.addReplaceOriginUniqueItem(area_unique_item, replace_name, replace_pointer);
    }
    if (origin != replace_name && origin == '') {
      Table.addReplaceOriginUniqueItem(area_unique_item, replace_name, replace_pointer);
    }
  }

  static addManyItems(event) {
    let area_many_items = event.srcElement.parentNode;
    let origins = [...area_many_items.querySelectorAll("ul li")].map((li) => li.textContent);
    let replace_table = Table.attribute(area_many_items);
    let replace_pointer = area_many_items.querySelector('select').value;
    let replace_name = Table.searchByIdentifier(replace_table, replace_pointer);

    if (origins.filter((origin) => (origin == replace_name)).length == 0) {
      let checkbox = Table.addManyItems(area_many_items, replace_name, replace_pointer);
      Listener.bind(checkbox, Compound.removeManyItems);
    }
  }

  static removeManyItems(event) {
    let checkbox = event.srcElement;
    let name = event.srcElement.nextSibling;
    let li = event.srcElement.parentNode;

    if (checkbox.checked == true && li.className == 'origin') {
      let s = document.createElement('s');
      name.remove();
      s.innerHTML = name.textContent;
      li.insertAdjacentElement('beforeend', s);
    }
    if (checkbox.checked == false && li.className == 'origin') {
      let s = li.querySelector('s');
      s.remove();
      li.insertAdjacentText('beforeend', s.textContent);
    }
    if (checkbox.checked == true && li.className != 'origin') {
      li.remove();
    }
  }

  static coverPopup() {
    let popup = document.querySelector('dialog.popup');
    popup.close();
  }


  static changeStatusRegister(event) {
    let button = event.srcElement;
    let target = document.querySelector(`table.visible tr.${button.value}`);
    if (target.classList.contains('delete')) {
      target.classList.remove('delete');
      button.textContent = 'Excluir';
    } else {
      target.classList.add('delete');
      button.textContent = 'Desexcluir';
    }
  }
}

export default Compound;
