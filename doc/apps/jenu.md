# Jenu - Aplicación de Comandos de Sao

## Introducción
Jenu es una herramienta que te permite crear y ejecutar comandos personalizados en la consola de Sao. Puedes utilizarlo para automatizar tareas, interactuar con tu aplicación y realizar pruebas.

## Creación de Comandos
Puedes crear nuevos comandos en `jenu` utilizando la siguiente sintaxis:

```php
public static function command(string $command, callable $execute, string $help = "undefined", $type = "undefined")
```

Por ejemplo, si deseas crear un comando simple que muestre "Hola mundo" en la consola, puedes hacerlo de la siguiente manera:

```php
Jenu::command('hi', function(){
    Jenu::print("Hola mundo!");
}, 'Un comando para saludar al mundo', 'tu_app:Test');
```

Cuando ejecutes:

```sh
php jenu hi
```

Verás en la consola la salida "Hola mundo".

## Descripción de Parámetros
- `command:` El nombre del comando que deseas crear.
- `execute:` La función que se ejecutará cuando se llame al comando.
- `help:` Una descripción opcional del comando.
- `type:` El tipo de comando, como base de datos, aplicación, etc. (Opcional).

## Ejecución de Comandos
Puedes ejecutar comandos previamente definidos utilizando la función `execute`. Por ejemplo:

```php
Jenu::command('test', function(){
    Jenu::print("Ejecutando el comando hi");
    Jenu::execute("hi");
    Jenu::print("El comando hi fue ejecutado!");
});
```

Esto mostrará en la consola:

```
Ejecutando el comando hi
Hola mundo!
El comando hi fue ejecutado!
```

## Condiciones
Puedes definir condiciones en tus comandos utilizando la función `condition`. Por ejemplo:

```php
$confirmation = Jenu::condition("¿Estás seguro de que deseas eliminar todas las tablas de la base de datos? (escribe YES o NO)");
```

El valor de `$confirmation` será un booleano según la respuesta del usuario. En la consola, verás:

```
¿Estás seguro de que deseas eliminar todas las tablas de la base de datos? (escribe YES o NO)
```

## Obtención de Argumentos
Puedes obtener argumentos pasados a un comando utilizando la función `get`. Por ejemplo:

```php
$host = Jenu::get(0, "Ingresa el Host", '127.0.0.1');
```

El primer parámetro especifica la posición del argumento. Si el argumento no existe, se mostrará un error y se detendrá la ejecución del comando. El tercer parámetro es opcional y establece un valor predeterminado.


## Ejecución de Procesos Node.js (en desarrollo)
La función `executeNodeProcess` está diseñada para ejecutar procesos de Node.js en la consola y mostrar su salida. Por ejemplo:

```php
Jenu::executeNodeProcess('test.js');
```

## Funciones de Impresión
Para imprimir datos en la consola, Jenu ofrece 4 funciones útiles:
- `Jenu::print($text, $newLine = true)`: Imprime datos de forma normal.
- `Jenu::success($text, $start = true)`: Imprime mensajes de éxito (en verde).
- `Jenu::error($text)`: Imprime mensajes de error (en rojo) y detiene la ejecución.
- `Jenu::warn($text, $start = true)`: Imprime mensajes de advertencia (en amarillo).

## Funciones Adicionales
- `Jenu::baseDir()`: Obtiene el directorio base.
- `Jenu::getDate()`: Obtiene la fecha actual.

¡Utiliza Jenu para automatizar tareas y hacer que tu desarrollo sea más eficiente!