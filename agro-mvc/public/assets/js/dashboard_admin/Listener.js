class Listener {
  constructor() {
    this.context = new Map();
  }

  set(context_identifier) {
    this.context.set(
      context_class,
      document.querySelectorAll(context_identifier)
    );
  }

  listen(context) {
    Array.from(this.context.get(context)).forEach((element) => {
      element.addEventListener()
    });
  }
}

export default Listener;
