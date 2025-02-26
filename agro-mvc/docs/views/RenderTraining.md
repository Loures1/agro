# App/views

## class RenderTraining

---

### Table of Contents

---

#### Properties

##### `const FIELD_EMPLOYED_NAME`

- _It's the tag that denotes where stands employed name in the html._

##### `const FIELD_HERID_PROFESSION`

- _It's the tag that denotes where stands employed profession in the html._

##### `const FIELD_TRAINING_NUMBER`

- _It's the tag that denotes where stands training number in the html._

##### `const FIELD_TABLE_TRAINING_GRADUATE`

- _It's the tag that denotes where stands table cells of the training graduate\
  in the html._

##### `const FIELD_TABLE_TRAINING_NOT_GRADUATE`

- _It's the tag that denotes where stands table cells of the training not\
  graduate in the html._

##### `private $reportTraining: array`

- _It's an array comes of the \
  [ReportTraining->getReportTraining()](/agro-mvc/docs/model/ReportTraining.md)._

##### `private $metaData: array`

- _It's an array about **$reportTraining**._

##### `private $nameEmployed: string`

- _It's employed's name._

##### `private $professionEmployed: string`

- _It's employed's profession._

---

#### Methods

##### `public view: ($pathHtml)-> void`

- _It mounts html page with the informations inside._

##### `private mountTableTrainingGraduate: string`

- _It mounts a table row with the informations about training graduate._

##### `private mountTableTrainingNotGraduate: string`

- _It mounts a table row with the informations about not training graduate._

##### `private getTrainingNumber: int`

- _It returns o number of the training._

---
