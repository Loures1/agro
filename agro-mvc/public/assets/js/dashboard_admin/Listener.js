class Listener {
  #context;
  constructor(context) {
    this.#context = Array.from(context);
    this.#context.forEach((item) => {
      element.addEventListener();
    })
  }

  listen(context) {
    Array.from(this.context.get(context)).forEach((element) => {
      element.addEventListener()
    });
  }
}

export default Listener;
