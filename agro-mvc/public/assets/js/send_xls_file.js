document.getElementById("file-upload").addEventListener("change", function () {
  const fileName = this.files[0]?.name || "Nenhum arquivo escolhido";
  document.querySelector(".file-name").textContent = fileName;
});
