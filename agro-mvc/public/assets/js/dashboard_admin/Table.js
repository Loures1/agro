class Table {
    #element;

    constructor(element) {
        this.#element = element;
    }

    get buttons() {
        return [this.#element.querySelectorAll("button")];
    }
}

export default Table;