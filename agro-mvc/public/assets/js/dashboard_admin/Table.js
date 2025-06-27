class Table {
    /**
     * 
     * @param {HTMLButtonElement} button 
     */
    static row(button) {
        let row_data = [
            ...document
            .querySelector(`table.visible tr.${button.value}`)
            .querySelectorAll(Table.#selector())
        ];

        return row_data;
    }

    static #selector() {
        let selector = [
            ...document
            .querySelectorAll("table.visible tr th")
        ]
        .filter((data) => (data.className))
        .map((data) => (`td.${data.className}`))
        .toString();

        return selector;
    }
}

export default Table;