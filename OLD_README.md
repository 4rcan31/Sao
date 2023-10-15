# Sao - Un Framework de PHP

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://github.com/4rcan31/Sao)

Sao es un framework de desarrollo web en PHP diseñado para crear aplicaciones de manera rápida y eficiente. Utiliza el enrutamiento y sigue el patrón de diseño Modelo Vista Controlador (MVC). Aunque inicialmente se creó con fines educativos, Sao es un marco que puede utilizarse en proyectos más grandes.

## Características Destacadas

- Generación de rutas de forma programática sin necesidad de modificar el archivo `.htaccess`.
- Sistema de maquetación basado en "0 HTML" que permite escribir código HTML utilizando funciones PHP.
- Incluye un ORM básico para procesar consultas `select`.
- Adherencia al patrón de diseño Modelo Vista Controlador (MVC).

## Instalación

Para usar Sao, es necesario tener [Laragon](https://laragon.org/download.html) instalado.

1. Clona el repositorio Sao en tu servidor Apache:
   ```sh
   git clone https://github.com/4rcan31/Sao.git
   ```

2. Accede al directorio clonado:
   ```sh
   cd Sao
   ```

3. Para cargar las variables de entorno definidas en el archivo `.env`, se requiere la biblioteca `vlucas/phpdotenv`. Si no tienes Composer instalado, descárgalo [aquí](https://getcomposer.org/download) y ejecuta el siguiente comando:
   ```sh
   composer require vlucas/phpdotenv
   ```

Con estos pasos, Sao estará listo para funcionar. Asegúrate de que Laragon esté en ejecución y luego navega a `sao.test:8080` en tu navegador.

## Uso de Sao

### Rutas

En Sao, la configuración de las rutas es el primer paso para crear una aplicación. Esto se logra mediante el archivo `routes/web.php`, donde puedes definir todas las rutas de tu aplicación. Puedes utilizar los métodos `get`, `post`, `put` y `delete` de la clase `Router`:

```php
Router::get('/', function($data){
    // Tu código aquí
});
```

La función de callback recibe un parámetro `$data`, que contiene todos los datos de la solicitud.

### Controladores

Sao no impone muchas convenciones, lo que te permite estructurar tu aplicación según tus necesidades. Aunque podrías ejecutar toda la aplicación en el callback de la ruta, se recomienda seguir buenas prácticas. Puedes utilizar el método `controller()` para llamar a un controlador que maneje la lógica de una ruta:

```php
Router::get('/', function($data){ 
   controller('IndexController', 'home', 'table.model', $data);
});
```

La función `controller()` recibe los siguientes parámetros:

- `$nameController`: El nombre del controlador que debe coincidir con el nombre de la clase en `app/Controllers`.
- `$function`: El nombre del método en la clase del controlador que se ejecutará al visitar la ruta.
- `$nameModel`: El nombre del modelo correspondiente al controlador (debe coincidir con el nombre de la clase en `app/Models`).
- `$data`: Todos los datos necesarios para el método especificado.
- `$imports`: Clases que se guardarán en un constructor del controlador para su uso posterior.

### Base de Datos

La configuración de la base de datos se realiza en el archivo `.env`. Debes definir tus credenciales de base de datos en este archivo.

```env
APP_NAME=Sao
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=testing_api
DB_USERNAME=root
DB_PASSWORD=
```

Nota: La función `hash` en Sao es unidireccional y no se puede revertir.

## Controladores en Sao

En Sao, los controladores se utilizan para administrar la lógica de la aplicación. Siguiendo buenas prácticas, se llama al controlador desde el archivo de rutas para mantener la estructura MVC. Aquí hay un ejemplo de cómo se utiliza un controlador en Sao:

### routes/web.php

```php
Router::get('/', function($data){ 
   controller('IndexController', 'home', 'table.model', $data);
});
```

### Controllers/IndexController.php

```php
class IndexController extends BaseController{
    public function home($data){
        view('index');
    }
}
```

### app/Views/index.php

```php
<?php



inithtml();
html('s', [
    'lang' => 'en'
]);

headRemast('Home', requires([
    'https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css'
]));
    h1('s'); 
        print('Esto es un h1');
    h1('e');

html('e');
```

Con Sao, puedes ejecutar bucles y condicionales en tu código HTML mediante funciones PHP. Para ello, puedes utilizar las funciones de creación de etiquetas HTML disponibles en Sao, siguiendo la estructura `nombreEtiqueta('s', $atributos)`. Estas funciones permiten definir etiquetas HTML, agregar atributos y contenido. Además, Sao admite la creación de nuevas funciones HTML personalizadas.

### Helpers en Sao

Sao proporciona dos helpers útiles: `Encrypt` y `Hasher`.

#### Encrypt

`Encrypt` ofrece funciones para cifrar y descifrar datos:

- `encrypt($string, $key)` cifra una cadena de texto.
- `decrypt($string, $key)` descifra una cadena de texto previamente cifrada.

#### Hasher

`Hasher` proporciona funciones de hash:

- `hash($string)` crea un hash de una cadena de texto.
- `verifyHash($string, $hash)` verifica si una cadena de texto coincide con un hash existente.

## Licencia

MIT