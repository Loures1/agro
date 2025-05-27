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
            Dashboard.mountPoup(button.value)
            Popup.show()
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

  mountPoup: function(target) {
    Content.poup.innerHTML = null
    let register = Content.getRegister(target)
    register = register.filter((field) => field.className)
    register.forEach((field) => {
      switch (field.firstChild.nodeName) {
        case "#text":
          Content.poup.innerHTML += Popup.mountText(field)
          break
        case "UL":
          Content.poup.innerHTML += Popup.mountSelect(field)
          break
      }
    })
  }
}

const Content = {
  tables: Array.from(document.querySelectorAll("table")),

  poup: document.querySelectorAll("dialog > div.content").item(0),

  getRegister: function(target) {
    return Array.from(
      document.querySelectorAll(`#${target}`)
        .item(0)
        .children
    )
  }
}

const Popup = {
  show: function() {
    document.querySelector("dialog").showModal()
  },

  mountText: function(field) {
    let label_title = field.className
    let placeholder = field.innerHTML
    let text = `
      <label>
        ${label_title}:
        <input type="text" placeholder="${placeholder}">
      </label><br>`
    return text
  },

  mountSelect: function(field) {
    let table =  Content.tables
    table = table.filter((table) => table.className == field.className).shift()
    table = Array.from(table.querySelectorAll("tr"))
    table = table.filter((register) => register.id)
    var option = ""
    table.forEach((register) => {
      option += `
        <option value="${register.id}">
          ${register.querySelector(".name").innerHTML}
        </option>`
    })
    let select = `<select>${option}</select>`
    let list_items = Array.from(field.querySelectorAll('li'))
    let string_items = ""
    list_items.forEach((item) => {
      string_items += `<li>${item.innerHTML}<button>X</button></li>`
    })
    string_items = `<ul>${string_items}</ul>`
    let content = `<div>${string_items}${select}</div>`
    return content
  }
}

Dashboard.listener()