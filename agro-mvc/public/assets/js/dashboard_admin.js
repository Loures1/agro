let Tables = {
  buttons: Array.from(document.getElementsByClassName("switch")),

  tables: Array.from(document.getElementsByTagName("table")),
  set: function (button) {
    this.tables.map((_) =>
      _.id == button.value
        ? (_.style.display = "block")
        : (_.style.display = "none"),
    );
  },
};

let PoupEdit = {
  poups: Array.from(document.getElementsByClassName("popup_edit")),
  
  buttons: Array.from(document.getElementsByClassName("action")),

  layout: function (button) {
    return document.getElementById(button.value);
  },

  set: function (button) {
    var type_poup = Tables.tables.filter((_) => _.contains(button)).shift();
    var poup = this.poups.filter((_) => _.classList.filter((_) => _ == type_poup.className));
    console.log(poup);
    return 0;
    var row = Array.from(document.getElementById(button.value).children);
    poup.forEach((field_poup) => {
      row.forEach((field_row) => {
        if (field_poup.className == field_row.className) {
          field_poup.className != 'trainings' 
            ? (field_poup.placeholder = field_row.innerHTML)
            : (field_poup.innerHTML = field_row.innerHTML);
        }
      });
    });  
  },
};

Tables.buttons.forEach((button) => {
  button.addEventListener("click", function () {
    Tables.set(button);
  });
});

PoupEdit.buttons.forEach((button) => {
  button.addEventListener("click", function () {
    if (button.name == "edit") {
      PoupEdit.set(button);
    }
  });
});
