const Dashboard = {
  status: "employed",

  buttons: Array.from(document.querySelectorAll("button")),

  listener: function() {
    this.buttons.forEach((button) => {
      button.addEventListener("click", function() {
        switch (button.className) {
          case "switch":
            Dashboard.status = Dashboard.defineTable(button.value)
            break
          case "edit":
            Dashboard.mountPoupEdit(button.value)
            break
        }
      })
    })
  },

  defineTable: function(target) {
    Content.tables.forEach((table) => {
      if (table.className == target) {
        table.style.display = "block"
      } else {
        table.style.display = "none"
      }
    })
    return target
  },

  mountPoupEdit: function(target) {
    let register = Content.getRegister(target)
    register = register.filter((field) => field.className)
    register.forEach((field) => {
      switch (field.firstChild.nodeName) {
        case "#text":
          Content.poup_edit.innerHTML = ``
          break
      }
    })
  }
}

const Content = {
  tables: Array.from(document.querySelectorAll("table")),

  poup_edit: document.querySelectorAll("dialog > div.content").item(0),

  getRegister: function(target) {
    return Array.from(
      document.querySelectorAll(`#${target}`)
        .item(0)
        .children
    )
  }
}

Dashboard.listener()
