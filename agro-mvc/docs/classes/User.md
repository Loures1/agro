# App/Classes

## Class User

### Table of Contents

____

#### Properties

##### `private $insertObj: [Insert](/agro-mvc/docs/classes/Insert.md)`

##### `private $selectExistsObj: [SelectExists](/agro-mvc/docs/classes/SelectExists.md)`

##### `private $dataBaseObj: mysqli`

____

#### Methods

##### `private execQueryDataBase: ($query: string) -> object mysqli`

- _It opens connection with data base, executes query, closes connection and \
returns **obejct myqli** whith a result._

##### `public registerUser: ($target: string, $datas: array) -> void`

- _It register user in data base._

##### `public assertUser: ($target: string, $fields: array, $condition: string) ->  bool`

- _It asserts whether a user to exist._

____
