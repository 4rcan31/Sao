# Uso de Sao

Para comenzar a utilizar Sao y crear tu primer "Hola Mundo", debes familiarizarte con las rutas. Sao utiliza varias bibliotecas y aplicaciones para funcionar, pero en esta sección nos centraremos en cómo hacer que una aplicación funcione. Empezaremos por la creación de rutas, que se encuentran en el directorio `app/routes`. Todos los archivos en esta carpeta serán manejados por el enrutador de Sao. Para crear una ruta, utiliza la siguiente función:

```php
Route::get('/home', function($request){
    res('Hola mundo');
});
```

Cuando visites la ruta `/home`, se enviará una respuesta en formato JSON que dirá "Hola mundo". La función `res()` toma un array o una cadena como parámetro y lo convierte en JSON para que sea la respuesta. Esto es solo un ejemplo de respuesta; puedes implementar lógica más compleja. Todos los datos de la solicitud están disponibles en la variable `$request`. Puedes acceder a datos específicos de la solicitud de la siguiente manera:

```php
Request::$path;
Request::$method;
Request::$uri;
Request::$requestTime;   
Request::$headers;
Request::$ip;
Request::$data;
Request::$cookies;
Request::$tokenRequest;
```

Ahora que tienes acceso a los datos de la solicitud, puedes realizar cualquier lógica que necesites. Puedes responder con JSON o incluso renderizar una vista. Si deseas renderizar una vista, puedes utilizar la función `view()`.

```php
Route::get('/home', function($request){
   view('home');
});
```

La función `view` busca un archivo en `app/views`, en este caso, un archivo llamado `home.php`, y lo renderiza. La función `view` también admite un segundo parámetro para pasar datos a la vista:

```php
view('home', $request);
```

Este segundo parámetro permite pasar datos a la vista para que puedan procesarse allí:

```php
<?php 
// Archivo home.php
$data = ViewData::get(); 
```

Una vez que se obtienen los datos, `ViewData::get();` se vacía automáticamente (los datos en la clase se destruyen).

Si necesitas validar datos, puedes utilizar la función `validate($data)`. Aquí tienes un ejemplo:

```php
Route::get('/home', function($request){
    $validate = validate($request);
    $validate->rule('required', ['name', 'password', 'email']);
    $validate->rule('email', ['email']);
    $validationResult = $validate->validate();
});
```

La función `validate` es parte de las bibliotecas de Sao y se utiliza para validar datos, en este caso, los datos del `$request`. El método `$validate->validate()` devuelve un valor booleano: `true` si todas las validaciones son exitosas y `false` si alguna falla. Las reglas de validación disponibles son las siguientes:

- `required`: Requerir un índice (verifica que exista y no esté vacío).
- `contain`: Verifica si una cadena contiene una subcadena.
- `email`: Valida si una cadena contiene al menos un símbolo "@".
- `is`: Valida el tipo de dato.
- `in`: Valida si un array existe dentro de otro.
- `numeric`: Valida si un valor es un número.
- `phone`: Valida si un valor es un número de teléfono.

Ten en cuenta que el validador en `/core/validate/validate.php` puede tener algunos errores en algunas de las reglas (excepto en `required`, `email`, `contain` y `phone`).

Puedes desarrollar toda tu aplicación en una sola ruta, pero es mejor dividirla en partes y usar controladores. Para usar controladores, puedes hacer lo siguiente:

```php
Route::get('/home', function($request){
     controller('ViewController', 'home', $request);
});
```

Lo que hace esto es buscar un archivo llamado `app/Controllers/ViewController.php`, instanciar su clase y ejecutar la función `home()`. El tercer parámetro es opcional y se puede utilizar para pasar datos a la función `home()`.

Cuando creas controladores, el nombre del archivo y el nombre de la clase deben ser iguales. Por ejemplo:

```php
<?php
// Archivo ViewController.php

class ViewController extends baseController{

    public function home($request){
        view('home');
    }
}
```

Ahora puedes llamar a un controlador y seguir toda tu lógica de programación para construir tu aplicación. Sin embargo, todavía no puedes realizar consultas en tu base de datos. Para hacerlo, debes usar un modelo. Para llamara los modelos, utiliza la función `model()` de la siguiente manera:

```php
<?php
// Archivo ViewController.php

class ViewController extends baseController{

    public function home($request){
       model('users');
    }
}
```

Esta función buscará un archivo llamado `app/Models/users.php` e instanciará una clase llamada `users`.

Nota: Al crear modelos, el nombre del archivo y el nombre de la clase deben ser iguales. Lo que significa que no recibirás sugerencias de métodos de la clase `users` en tu IDE. Si deseas habilitar sugerencias de métodos, puedes hacer lo siguiente:

```php
<?php
// Archivo ViewController.php

class ViewController extends baseController{

    /**
    * @return users
    */
    public function users(){
        return model('users');
    }

    public function home($request){
      $this->users();
    }
}
```

De esta manera, tu IDE reconocerá la clase y sugerirá métodos. ¿Pero cómo se ve la clase `users`?

```php
<?php
// Archivo users.php

class users extends baseModel{

    public $table = 'users';

    public function get(){
        $this->prepare();
        $this->select(['*'])
        ->from($this->table);
        return $this->execute->all('fetchAll');
    }

    public function byId(int $id){
        $this->prepare();
        $this->select(['*'])
        ->from($this->table)
        ->where('id_user', $id, '=');
        return $this->execute()->all();
    }
}
```

Si has configurado tu base de datos, tus modelos podrán interactuar con ella. En este caso, el modelo `users` contiene dos métodos: `get`, que recupera todos los registros de la tabla `users`, y `byId`, que recupera una fila por su `id` (el cual se pasa como parámetro). Si observas, Sao utiliza un constructor de consultas SQL para facilitar las consultas. Sin embargo, si deseas realizar consultas SQL estándar, puedes hacerlo de la siguiente manera:

```php
    public function byId(int $id){
        $result = $this->query(
            "SELECT * FROM users WHERE id_users = ?", 
            $id);
    }
```

Ahora, la variable `$result` contiene métodos PDO que puedes utilizar, como `fetch` o `fetchAll`, según tus necesidades.

¡Ahora tienes las herramientas necesarias para comenzar a construir tu aplicación con Sao! Puedes trabajar en las rutas, controladores y modelos para crear una aplicación web robusta y personalizada. 