const themeToggleButton = document.getElementById('theme-toggle');
const bodyElement = document.body;

let isDarkTheme = false;

function toggleTheme() {
    if (isDarkTheme) {
        bodyElement.classList.remove('dark-theme');
        bodyElement.classList.add('light-theme');
        themeToggleButton.classList.remove('dark-theme');
        themeToggleButton.classList.add('light-theme');
        themeToggleButton.textContent = "Trocar para Dark";
    } else {
        bodyElement.classList.remove('light-theme');
        bodyElement.classList.add('dark-theme');
        themeToggleButton.classList.remove('light-theme');
        themeToggleButton.classList.add('dark-theme');
        themeToggleButton.textContent = "Trocar para Light";
    }

    isDarkTheme = !isDarkTheme;
}

themeToggleButton.addEventListener('click', toggleTheme);
