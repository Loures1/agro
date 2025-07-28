document.addEventListener("DOMContentLoaded", function () {
  const hoje = new Date();

  const linhasCursos = document.querySelectorAll(
    "table:first-of-type tr:not(:first-child)"
  );

  linhasCursos.forEach((linha, index) => {
    const celulas = linha.querySelectorAll("td");
    if (celulas.length < 2) return;

    const nomeCurso = celulas[0]?.textContent.trim();
    const textoData = celulas[1]?.textContent.trim();

    console.log(`Linha ${index + 1}: valor bruto da data -> ${textoData}`);

    if (!textoData || textoData.toLowerCase().includes("null")) {
      celulas[1].textContent = "Data não disponível";
      return;
    }

    let dataValidade;

    // Tenta detectar e converter data em formato dd-mm-aaaa
    const regexDMY = /^(\d{2})-(\d{2})-(\d{4})$/;
    const matchDMY = textoData.match(regexDMY);
    if (matchDMY) {
      const [_, dia, mes, ano] = matchDMY;
      dataValidade = new Date(`${ano}-${mes}-${dia}`);
    } else {
      // Tenta converter diretamente (funciona para ISO e alguns formatos locais)
      dataValidade = new Date(textoData);
    }

    if (!isNaN(dataValidade.getTime())) {
      // Formata de volta para dd-mm-aaaa
      const dia = String(dataValidade.getDate()).padStart(2, "0");
      const mes = String(dataValidade.getMonth() + 1).padStart(2, "0");
      const ano = dataValidade.getFullYear();

      celulas[1].textContent = `${dia}-${mes}-${ano}`;

      // Marcar se estiver vencido
      if (dataValidade < hoje) {
        linha.classList.add("expired");
      }
    } else {
      celulas[1].textContent = "Formato desconhecido";
    }
  });
});
