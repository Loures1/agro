const switchs = Array.from(document.getElementsByClassName("switch"));
const tables = Array.from(document.getElementsByClassName("table"));
const btn_poup = Array.from(document.getElementsByClassName("action"));

let PoupEmployed = {
  set: function (btn) {
    let placeholders = this.placeholders();
    let placeholders_values = this.placeholders_values(btn);
    placeholders.forEach((_) => {
      if (placeholders_values.has(_.id)) {
        _.id == "trainings"
          ? (_.innerHTML = placeholders_values.get(_.id))
          : (_.placeholder = placeholders_values.get(_.id));
      }
    });
  },

  placeholders: function () {
    return Array.from(document.getElementById("edit_employed").children).filter(
      (_) => _.id,
    );
  },

  placeholders_values: function (btn) {
    let tr_html = Array.from(document.getElementsByClassName("employeds"))
      .filter((_) => _.contains(btn))
      .shift();
    return new Map(
      Array.from(tr_html.children).map((_) => [_.id, _.innerHTML]),
    );
  },
};

switchs.forEach((element) => {
  element.addEventListener("click", function () {
    tables.forEach((table) =>
      table.id == element.id
        ? (table.style.display = "block")
        : (table.style.display = "none"),
    );
  });
});

btn_poup.forEach((btn) => {
  btn.addEventListener("click", function () {
    if (btn.id == "edit") {
      console.log(PoupEmployed.set(btn));
    }
  });
});
