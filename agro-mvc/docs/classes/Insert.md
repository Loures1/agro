# App/classes

## class Insert

- _Implements interface [Query](/agro-mvc/docs/classes/Query.md)._

---

### Table of Contents

---

#### Properties

##### `const SYNTAX_INSERT = "INSERT INTO target (columns) VALUES (values)"`

##### `private $target: string`

- _Table name in database._

##### `private $values: array`

- _Values that are part the insert._

##### `private $columns: array`

- _Columns that are part of table._

##### `private $query: array`

- _The code sql that will to be executed._

---

#### Method

##### `private traitmentValuesFromQuery: string`

- _It receives **$values** and return a string for replace values in sql._

##### `public getTarget: string`

- _It returns **$target**._

##### `public getValues: array`

- \_It returns **$values**.\_It

##### `public getColumns: array`

- _It returns **$columns**._

##### `public getQuery: string`

- _It returns **$query**._

##### `public execQuery: void`

- _It executes **$query** in data base._

---
