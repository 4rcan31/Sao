# DataBase - Aplicación de Base de Datos de Sao

La aplicación "DataBase" en Sao se enfoca en la manipulación de bases de datos. Esta aplicación se divide en tres partes esenciales: `connection`, `constructor`, y `migrations`.

## Connection

La parte de conexión es la más sencilla y se basa en establecer la conexión con la base de datos. Para lograrlo, es necesario configurar el archivo `.env`.

## Constructor

La aplicación "Constructor" te permite construir consultas SQL utilizando métodos de PHP. Veamos cómo se utiliza con un ejemplo de un pequeño CRUD.

### Crear (Create)

Para insertar datos, se realiza de la siguiente manera:

```php
$db = new DataBase();
$db->prepare();
$db->insert('users')->values([
    'email' => 'test@gmail.com',
    'password' => '123'
]);
$lastIdInserted = $db->execute()->lastId();
```

En este caso, estamos insertando datos en la tabla `users`. En el array que se pasa al método `values`, los índices representan los nombres de las columnas y los valores son los datos que se insertarán. Al ejecutar esta consulta, puedes obtener el último ID insertado utilizando el método `lastId()`.

### Leer (Read)

Para traer datos (select), se realiza de esta manera:

```php
$db = new DataBase();
$db->prepare();
$db->select(['*'])->from('users');
$data = $db->execute()->all('fetchAll');
```

Este ejemplo selecciona todas las columnas de la tabla `users` y recupera todos sus datos. Si deseas seleccionar solo algunas columnas, puedes hacerlo de la siguiente manera:

```php
$db = new DataBase();
$db->prepare();
$db->select(['id', 'name'])->from('users');
$data = $db->execute()->all('fetchAll');
```

Aquí se seleccionan todas las columnas de la tabla `users`, pero solo las columnas `id` y `name`. Si deseas aplicar una condición `WHERE`, puedes hacerlo de la siguiente manera:

```php
$db = new DataBase();
$db->prepare();
$db->select(['id', 'name'])
    ->from('users')
    ->where('id', 2);
$data = $db->execute()->all();
```

En este caso, estamos solicitando el `id` y el `name` de la tabla `users` donde el `id` sea igual a `2`. No es necesario pasar `'fetchAll'` como parámetro al método `all()` porque sabemos que solo obtendremos una fila.

### Actualizar (Update)

Para actualizar tablas utilizando el constructor, se utiliza el método `update` de la siguiente manera:

```php
$db = new DataBase();
$db->prepare();
$db->update('users', [
    'name' => 'nuevo nombre'
])->where('id', 2);
$db->execute();
```

El método `update` recibe dos parámetros: el primero es el nombre de la tabla que se va a actualizar, y el segundo es un array con los nuevos valores que se actualizarán. Similar al método `values` de `insert`, el segundo parámetro de `update` contiene índices que representan los nombres de las columnas y valores que representan los datos que se actualizarán. Luego, se establece una condición `WHERE` para especificar dónde se realizará la actualización.

### Eliminar (Delete)

Para eliminar filas, puedes hacer lo siguiente:

```php
$db = new DataBase();
$db->prepare();
$db->delete('users')->where('id', 2);
$db->execute();
```

El método `delete` recibe como parámetro el nombre de la tabla de la que se eliminarán las filas. Luego, se establece una condición `WHERE`.

Si prefieres no utilizar el constructor de consultas, puedes crear tu propia consulta SQL de esta manera:

```php
$db = new DataBase();
$data = $db->query('SELECT * FROM user WHERE id = ?', 1)->fetchAll();
```

Sao respeta la sintaxis de PDO de PHP para prevenir la inyección de SQL. El método `query` retorna métodos de PDO que puedes utilizar en cualquier momento.

## Migraciones

El sistema de migraciones aún se encuentra en desarrollo y presenta algunas limitaciones. Para crear una migración, ejecuta el siguiente comando:

```sh
php jenu make:migration name_migration
```

Este comando creará un archivo llamado `app/Database/migrations/name_migration.php`. El archivo tendrá una estructura como esta:

```php
<?php
class name_migration extends Migration {

    public function up() {
        $this->create("name_migration", function($table) {

        });
    }

    public function down() {
        $this->dropIfExist("name_migration");
    }
}
```

Para crear la tabla, debes ejecutar una consulta SQL manualmente utilizando el método `query`, de la siguiente manera:

```php
<?php
class name_migration extends Migration {

    public function up() {
        $this->create("name_migration", function($table) {
            $this->query('CREATE TABLE name_migration (
                id INT PRIMARY KEY AUTO_INCREMENT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )');
        });
    }

    public function down() {
        $this->dropIfExist("name_migration");
    }
}
```

Lamentablemente, el sistema de migraciones aún no admite claves foráneas (foreng keys) debido a la forma en que se ejecutan las migraciones para subirlas a la base de datos. Por lo tanto, si deseas establecer relaciones, debes crear las columnas relacionadas sin definir una clave foránea. Para ejecutar tus migraciones ejecuta:

```sh
php jenu execute:migrations
```