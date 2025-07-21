const Dashboard = {
  get buttons() {
    let list_buttons = Array.from(document.querySelectorAll('button'));
    return list_buttons;
  },

  bind(button, fn) {
    button.addEventListener('click', (e) => fn(e.target.value));
  },

  changeTable(target) {
    let visible_table = document.querySelector(`table.${target}`);
    let hidden_table = document.querySelector('table.visible');
    hidden_table.classList.replace('visible', 'hidden');
    visible_table.classList.replace('hidden', 'visible');
  },

  create() {
    let target = Array.from(document.querySelector('table.visible').classList)
      .filter((name) => (name != 'visible'))
      .shift();

    window.location.assign(`/admin/create/${target}`);
  },

  edit(target) {
    window.location.assign(`/admin/edit/${target}`);
  },

  delete(target) {
    window.location.assign(`/admin/delete/${target}`);
  }
};

Dashboard.buttons.forEach((button) => {
  switch (button.className) {
    case 'switch': return Dashboard.bind(button, Dashboard.changeTable);
    case 'edit': return Dashboard.bind(button, Dashboard.edit);
    case 'delete': return Dashboard.bind(button, Dashboard.delete);
    case 'create': return Dashboard.bind(button, Dashboard.create);
  }
});
