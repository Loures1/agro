const switchs = Array.from(document.getElementsByClassName("switch"));
const tables = Array.from(document.getElementsByClassName("table"));
const btn_poup = Array.from(document.getElementsByClassName("action"));
const employeds_table = Array.from(
  document.getElementsByClassName("employeds")
);
const edit_employed = Array.from(
  document.getElementById("edit_employed").children
);

let PoupEmployed = {
  placeholders: function () {
    return Array.from(
      document.getElementById("edit_employed").children)
      .filter(_ => _.id);  
  },

  placeholders_values: function(element) {
    
  }
}

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
      employeds_table.forEach((employed_table) => {
        if (employed_table.contains(btn)) {
          console.log(edit_employed);
        }
      });
    }
  });
});
