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
  buttons: Array.from(document.getElementsByClassName("action")),

  layout: function (button) {
    return document.getElementById(button.value)
  },

  set: function (button) {
    var type_poup = Tables.tables
    .filter((_) => _.contains(button))
    .shift()
    var poup = Array.from(
      document.querySelector(`.${type_poup.className}.poup_edit`).children
      .item(0)
      .children
      ).filter((_) => _.className);
    return poup;
  },
};

Tables.buttons.forEach((button) => {
  button.addEventListener("click", function () {
    Tables.set(button);
  });
});

PoupEdit.buttons.forEach((button) => {
  button.addEventListener("click", function () {
    if (button.name == 'edit') {
      console.log(PoupEdit.set(button));
    }
  });
});
