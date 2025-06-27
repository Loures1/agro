class Poup {
    static get text() {
        return `{header}:<input type="text" placeholder="{value}"><br>`;
    }

    static get list() {
        return `
        <div class="{button_schema}">
            <label> {header}:
                {list_unorder}
                <select>
                    {options}
                </select>
                {button}
            </label>
        </div>`;
    }

    static get manyItems() {
        return "";
    }

    static get uniqueItem() {
        return "";
    }
};