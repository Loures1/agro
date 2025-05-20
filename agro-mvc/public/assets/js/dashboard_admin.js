let Tables = {
  state: 'employed',
  buttons: Array.from(document.getElementsByClassName("switch")),
  tables: Array.from(document.getElementsByTagName("table")),

  set: function (button) {
    this.tables.map((_) => {
      if (_.className == button.value) {
        _.style.display = "block"
        this.state = _.className
      } else {
        _.style.display = "none"
      }
    }
    );
  },
};

let Popup = {
  poups: Array.from(document.getElementsByClassName('popup_edit')),

  buttons: Array.from(document.getElementsByClassName('action')),

  set: function (button) {
    let popup = document.getElementsByClassName(`${Tables.state} popup_edit`)
    let register = document.getElementById(button.value)
    return Array.from(popup)
  }
}

Tables.buttons.forEach((button) => {
  button.addEventListener("click", function () {
    Tables.set(button);
  });
});

Popup.buttons.forEach((button) => {
  button.addEventListener("click", function () {
    if (button.name == 'edit') {
      console.log(Popup.set(button))
    }
  });
})
