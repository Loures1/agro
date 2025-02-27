# App/Model

## class ReportTraining

- _It extends superclass [Query](/agro-mvc/docs/classes/Query.md)._

---

### Table of Contents

---

#### Properties

##### `private $slpCode: string`

- _It's syntax of the SQL code that one will to do the query._

##### `private $report: array`

- _It's the return from database query._

##### `private $idEmployed: int`

- _It's employed's id._

---

#### Methods

##### `public get: array`

- _It returns **$report**._

##### `private getMedata: array`

- _It returns meta data from the return database query, such training number._

##### `private getNameEmployed: string`

- _It realizes a query in the database in which one returns the employed name._

##### `private getProfessionEmployed: string`

- _It realizes a query in the database in which one returns the employed \
  profession._

##### `private fetchReportTrainingInDataBase: array`

- _It realizes a query in the database in which one returns the trainings that \
  profession depends._

---
