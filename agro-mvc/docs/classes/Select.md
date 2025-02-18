# App/Classes

## Class Select

_Implements interface [Query](/agro-mvc/docs/classes/Query.md)._

### Table of Contents

____

#### Properties

##### `const SYNTAX_SQL = "SELECT fields FROM target condition`

##### `private $target: string`

- _It is going to replace 'target' in **const SYNTAX_SQL**._

##### `private $fields: array`

- _It is going to replace 'fields' in **const SYNTAX_SQL**._

##### `private $condition: array`

- _It is going to replace 'condition' in **const SYNTAX_SQL**._

##### `private $query: string`

- _It is sql code._

##### `private $result: array`

- _It result has returned of fetch data base._

____

#### Methods

##### `public getTarget: string`

- _It returns **$target**._

##### `public getFilds: array`

- _It returns **$fields**._

##### `public getCondition: string`

- _It returns **$condtion**._

##### `public getQuery: string`

- _It returns **$query**._

##### `public getResult: array`

- _It returns **$result**._

##### `public execQuery: void`

- _It executes the fetch in data base._

____
