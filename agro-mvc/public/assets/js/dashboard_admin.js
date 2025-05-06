const switchs = Array.from(document.getElementsByClassName("switch"));
const tables = Array.from(document.getElementsByClassName('table'));

switchs.forEach(element => {
    element.addEventListener('click', function() {
        tables.forEach(table => (table.id == element.id) 
        ? table.style.display = 'block' 
        : table.style.display = 'none');
    });
});