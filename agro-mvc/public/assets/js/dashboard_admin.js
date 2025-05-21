let dashboard = {
  state: "employed",
  scroll: "relative",
  modal: null,
  query: null
}

let Tables = {
  buttons: Array.from(document.getElementsByClassName("switch")),

  tables: Array.from(document.getElementsByTagName("table")),

  set: function(button) {
    this.tables.map((_) => {
      if (_.className == button.value) {
        _.style.display = "block"
        dashboard.state = _.className
      } else {
        _.style.display = "none"
      }
    }
    );
  },
};

let Popup = {
  exit_buttons: Array.from(document.getElementsByClassName("exit")),

  modals: Array.from(document.getElementsByTagName('dialog')),

  register_buttons: Array.from(document.getElementsByClassName('action')),


  set: function(button) {
    let popup = document.getElementsByClassName(`${dashboard.state} popup_edit`)
    popup = Array.from(popup[0].children)

    let modal = this.modals.filter((_) => _.className == dashboard.state)
      .shift()

    let registers = document.getElementById(button.value)
    registers = Array.from(registers.children)

    popup.forEach((field) => {
      registers.forEach((register) => {
        if (field.className == register.className) {
          field.className == 'trainings'
            ? (field.innerHTML = register.innerHTML)
            : (field.placeholder = register.innerText)
        }
      })
    })
    modal.showModal()
    document.body.style.position = "fixed"

    dashboard.modal = modal;
    dashboard.scroll = "fixed"
  }
}

Tables.buttons.forEach((button) => {
  button.addEventListener("click", function() {
    Tables.set(button);
  });
});

Popup.register_buttons.forEach((button) => {
  button.addEventListener("click", function() {
    if (button.name == 'edit') {
      Popup.set(button)
    }
  });
})

Popup.exit_buttons.forEach((button) => {
  button.addEventListener("click", function() {
    dashboard.modal.close()
    document.body.style.position = "relative"
    dashboard.scroll = "relative"
  })
})

document.addEventListener("keydown", function(event) {
  if (event.key == "Escape" && dashboard.scroll == "fixed") {
    document.body.style.position = "relative"
    dashboard.scroll = "relative"
  }
})

