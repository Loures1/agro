# App/Clases

## class ExtractorXlsx

- _Implements **IteratorAgregate**_

---

### Table of Contents

---

#### Properties

##### `private $cells: array`

- _All cells have just be extracted from table._

##### `private $heardCells: array`

- _The header that has just be extracted from table_.

##### `private $dataCells: array`

- _The datas that have just be extracted from table._

---

#### Methods

##### `public getAllCells: array`

- _return **$cells**._

##### `public getHeaderCells: array`

- _return **$headerCells**._

##### `public getDatasCells: array`

- _return **$dataCells**._

##### `public getIterator: Traversable`

- _Call iterator._

##### `private extractRows: array`

- _extract and return all the cells from table._

---
