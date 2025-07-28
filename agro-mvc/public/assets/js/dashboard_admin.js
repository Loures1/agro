const POPUP_PREFIX = "poup_";
const TABLE_EMPLOYED_ID = "table_employed";

let Tables = {
  buttons: Array.from(document.getElementsByClassName("switch")),
  tables: Array.from(document.getElementsByClassName("table")),

  set: function (tableId) {
    this.tables.forEach((table) => {
      table.style.display = table.id === tableId ? "table" : "none";
    });
  },
};

const Actions = {
  editar: () => {
    document.querySelectorAll(".btn-editar").forEach((button) => {
      button.addEventListener("click", function () {
        const popup = document.getElementById(POPUP_PREFIX + this.dataset.type);
        if (popup) popup.style.display = "flex";
      });
    });
  },

  esconder: () => {
    document.querySelectorAll(".btn-esconder").forEach((button) => {
      button.addEventListener("click", function () {
        const row = document.getElementById(this.dataset.id);
        if (row) row.style.display = "none";
      });
    });
  },

  excluir: () => {
    document.querySelectorAll(".btn-excluir").forEach((button) => {
      button.addEventListener("click", function () {
        const { id, type } = this.dataset;
        if (confirm("Tem certeza que deseja excluir este item?")) {
          window.location.href = `/excluir_${type}.php?id=${id}`;
        }
      });
    });
  },

  fecharPopup: () => {
    document.querySelectorAll(".popup").forEach((popup) => {
      popup.addEventListener("click", function (e) {
        if (e.target === this || e.target.classList.contains("btn-fechar")) {
          this.style.display = "none";
        }
      });
    });
  },
};

window.addEventListener("DOMContentLoaded", function () {
  Tables.set(TABLE_EMPLOYED_ID);

  Tables.buttons.forEach((button) => {
    button.addEventListener("click", () => Tables.set(button.value));
  });

  Actions.editar();
  Actions.esconder();
  Actions.excluir();
  Actions.fecharPopup();
});
