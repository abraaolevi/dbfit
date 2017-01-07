Dbfit
=====

Facilitating day-to-day SQL queries with PDO.

ATTENTION: it's a experimental version. Don't use it in production.

### INSTALLATION

```
composer require dbfit/pdo
```

### USAGE 
Simple queries:

```php
$dbfit = new Dbfit($host, $user, $password, $database);
$result = $dbfit->query("SELECT * FROM users");
```

Transactions queries:
```php
$dbfit->getConnection()->beginTransaction();
$dbfit->query($sql);
$dbfit->query($sql);
$dbfit->query($sql);
$dbfit->getConnection()->endTransaction();
```

You can cancel a transaction using `$dbfit->getConnection()->cancelTransaction();`

### Changelog
* v1.0.3
  - Adding flexybility with `prepareQuery` method
* v1.0.2
  - Some bugfixes at `ConnectionManager`
* v1.0.1
  - Fixing `composer.json`
* v1.0.0
  - Initial version

### Roadmap
* `select` method that returns result data
* `insert` method that returns `insert_id`
* `update` method that returns number of affected rows
* `delete` method that returns number of affected rows
* Other auxiliar methods: `join`, `where`, `groupBy`, `having`, `orderBy` `limit`, `offset`
* Aggregates methods: `count`, `distinctCount`, `max`, `min`, `avg`, `sum`
