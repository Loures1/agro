let Tables = {
  buttons: Array.from(document.getElementsByClassName("switch")),
  tables: Array.from(document.getElementsByClassName("table")),
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
    return Tables.tables.filter((_) => _.contains(button)).shift();
  },
  set: function (button) {},
};

Tables.buttons.forEach((button) => {
  button.addEventListener("click", function () {
    Tables.set(button);
  });
});

PoupEdit.buttons.forEach((button) => {
  button.addEventListener("click", function () {
    console.log(PoupEdit.layout(button));
  });
});
