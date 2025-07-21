const Compound = {
  get jobSelectOptions() {
    return Array.from(
      document.querySelectorAll('div.job select > option')
    );
  },

  get trainingSelectOptions() {
    return Array.from(
      document.querySelectorAll('div.training select > option')
    );
  },

  get originTrainingsCheckbox() {
    return Array.from(
      document.querySelectorAll('div.training ul > li > input[type="checkbox"]')
    );
  },

  get editButton() {
    return document.querySelector('button.edit');
  },

  get createButton() {
    return document.querySelector('button.create');
  },

  assemblyEmployedJson(id, name, mat, job, tel, email) {
    return {
      target: 'employed',
      id: id,
      name: name,
      mat: mat,
      job: job,
      tel: tel,
      email: email
    };
  },

  assemblyJobJson(id, name, remove, add) {
    return {
      target: 'job',
      id: id,
      name: name,
      trainings: {
        remove: [...remove],
        add: [...add]
      }
    };
  },

  assemblyTrainingJson(id, name) {
    return {
      target: 'training',
      id: id,
      name: name
    };
  },

  bind(target, fn) {
    target.addEventListener('click', (e) => fn(e));
  },

  addJob(event) {
    let ul = document.querySelector('.job-content > ul');
    let new_job = event.target;
    let void_job = ul.querySelector('li.job-null');
    let origin_job = ul.querySelector('li.origin');
    let li_size = Array.from(ul.querySelectorAll('li')).length;

    if (void_job) {
      let new_li = document.createElement('li');
      new_li.className = `not-origin ${new_job.value}`;
      new_li.textContent = new_job.textContent;
      ul.appendChild(new_li);
      void_job.remove();
    }

    if (!origin_job) {
      let not_origin = ul.querySelector('li.not-origin');
      not_origin.className = `not-origin ${new_job.value}`;
      not_origin.textContent = new_job.textContent;
    }

    if (origin_job && li_size == 1 && origin_job.textContent != new_job.textContent) {
      let new_li = document.createElement('li');
      let s = document.createElement('s');
      new_li.className = `new ${new_job.value}`;
      new_li.textContent = new_job.textContent;
      ul.appendChild(new_li);
      s.textContent = origin_job.textContent;
      origin_job.textContent = '';
      origin_job.appendChild(s);
    }

    if (origin_job && li_size == 2 && origin_job.textContent != new_job.textContent) {
      let new_li = ul.querySelector('li.new');
      new_li.className = `new ${new_job.value}`;
      new_li.textContent = new_job.textContent;
    }

    if (origin_job && li_size == 2 && origin_job.textContent == new_job.textContent) {
      let s = origin_job.querySelector('s');
      origin_job.textContent = s.textContent;
      s.remove();
      ul.querySelector('li.new').remove();
    }
  },

  addTraining(event) {
    let target = event.target;
    let ul = document.querySelector('.training ul');
    let void_li = ul.querySelector('li.training-null');

    if (void_li) {
      void_li.remove();
    }

    let origins = Array.from(ul.querySelectorAll('li'));

    origins = origins
      .filter((origin) => (origin.textContent == target.textContent));

    if (origins.length == 0) {
      let new_li = document.createElement('li');
      new_li.className = `new ${target.value}`;
      let new_input = document.createElement('input');
      new_input.type = 'checkbox';
      new_input.id = 'checkbox-input';
      let new_label = document.createElement('label');
      new_label.for = 'checkbox-input';
      new_li.appendChild(new_input);
      new_label.textContent = target.textContent;
      new_li.appendChild(new_label);
      ul.appendChild(new_li);

      Compound.bind(new_input, Compound.removeTraining);
    }
  },

  changeStatusOriginTraining(event) {
    let target = event.target;
    let label = target.nextSibling;

    if (target.checked) {
      let s = document.createElement('s');
      s.textContent = label.textContent;
      label.textContent = '';
      label.appendChild(s);
    } else {
      let s = label.querySelector('s');
      label.textContent = s.textContent;
      s.remove();
    }
  },

  removeTraining(event) {
    let target = event.target.parentNode;
    target.remove();
    let ul = document.querySelector('.training ul');
    let lis = ul.querySelectorAll('li');

    if (Array.from(lis).length == 0) {
      let void_li = document.createElement('li');
      void_li.className = 'training-null';
      void_li.textContent = 'Selecionar Treinamento';
      ul.appendChild(void_li);
    }
  },

  sendCreateJson() {
    let target = document.querySelector('h1').className;

    if (target == 'employed') {
      let name = document.querySelector('.name > input').value;
      if (!name) { return alert('Insira o nome') }

      let mat = document.querySelector('.mat > input').value;
      if (!mat) { return alert('Insira a matricula') }

      let job = document.querySelector('.job ul li.not-origin');
      if (!job) { return alert('Escolha Uma Profissao') }
      job = job.className.match(/\d+/g).shift();

      let tel = document.querySelector('.tel > input').value;
      if (!tel) { return alert('Insira um numero de telefone') }
      if (!tel.match(/\(\d{2}\)\s9\d{4}-\d{4}/g)) { return alert('Formato correto do numero de telefone: (DDD) 9****-****') }

      let email = document.querySelector('.email > input').value;
      if (!email) { return alert('Insira um email') }
      if (!email.match(/\w+\.\w+@gmail\.com/g)) { return alert('Formato de email nao esta correto') }

      var json = Compound.assemblyEmployedJson(
        null,
        name,
        mat,
        job,
        tel,
        email
      );
    }

    if (target == 'job') {
      let name = document.querySelector('.name > input').value;
      if (!name) { return alert('Insira um nome') }

      let add = Array.from(document.querySelectorAll('.training ul li.new'));
      if (add.length == 0) { return alert('Escolha os treinamentos') }

      add = add.map((li) => li.className.match(/\d+/g).shift());

      var json = Compound.assemblyJobJson(
        null,
        name,
        [null],
        add
      );
    }

    if (target == 'training') {
      let name = document.querySelector('.name > input').value;
      if (!name) { return alert('Insira um nome') }

      var json = Compound.assemblyTrainingJson(
        null,
        name
      );
    }
    Compound.sendJson('/admin/create', json);
  },

  sendEditJson() {
    let target = document.querySelector('h1').className;

    if (target == 'employed') {
      let id = document.querySelector('h2').className;

      let name = document.querySelector('.name > input');
      name = (name.value == "") ? name.placeholder : name.value;

      let mat = document.querySelector('.mat > input')
      mat = (mat.value == "") ? mat.placeholder : mat.value;

      let job = (document.querySelector('.job ul li.new'))
        ? document.querySelector('.job ul li.new').className.match(/\d+/g).shift()
        : null;

      let tel = document.querySelector('.tel > input');
      tel = (tel.value == "") ? tel.placeholder : tel.value;
      if (!tel.match(/\(\d{2}\)\s9\d{4}-\d{4}/g)) { return alert('Formato correto do numero de telefone: (DDD) 9****-****') }

      let email = document.querySelector('.email > input');
      email = (email.value == "") ? email.placeholder : email.value;
      if (!email.match(/\w+\.\w+@gmail\.com/g)) { return alert('Formato de email nao esta correto') }

      var json = Compound.assemblyEmployedJson(
        id,
        name,
        mat,
        job,
        tel,
        email
      );
    }

    if (target == 'job') {
      let id = document.querySelector('h2').className;

      let name = document.querySelector('.name > input');
      name = (name.value == "") ? name.placeholder : name.value;

      let remove = Array
        .from(document.querySelectorAll('.training ul li.origin > label > s'))
        .map((s) => s.parentNode.parentNode.className.match(/\d+/g).shift());

      let add = Array
        .from(document.querySelectorAll('.training ul li.new'))
        .map((s) => s.className.match(/\d+/g).shift());

      var json = Compound.assemblyJobJson(
        id,
        name,
        remove,
        add
      );
    }

    if (target == 'training') {
      let id = document.querySelector('h2').className;

      let name = document.querySelector('.name > input')
      name = (name.value == "") ? name.placeholder : name.value;

      var json = Compound.assemblyTrainingJson(
        id,
        name
      );
    }

    Compound.sendJson('/admin/edit', json);
  },

  sendJson(url, json) {
    fetch(`http://localhost${url}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json; charset=UTF-8'
      },
      body: JSON.stringify(json)
    })
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        switch (data) {
          case 0: return window.location.assign('/admin/dashboard');
          case 1062: return alert("Ja esta registrado.");
        }
      })
      .catch(error => console.error('Error:', error));
  }
};

Compound.jobSelectOptions.forEach((option) => {
  Compound.bind(option, Compound.addJob);
});

Compound.trainingSelectOptions.forEach((option) => {
  Compound.bind(option, Compound.addTraining);
});

Compound.originTrainingsCheckbox.forEach((option) => {
  Compound.bind(option, Compound.changeStatusOriginTraining);
});

if (Compound.createButton) {
  Compound.bind(Compound.createButton, Compound.sendCreateJson);
} else {
  Compound.bind(Compound.editButton, Compound.sendEditJson);
}
