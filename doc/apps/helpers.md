Aquí tienes la información presentada en un formato Markdown mejorado:

# Helpers - Aplicación de Funciones de Sao

Los Helpers se dividen en dos partes: aquellos que Sao utiliza para funcionar y otros Helpers generales.

## Helpers de Sao

Uno de los Helpers más importantes es la función `import()`:

```php
function import(string $module, bool $return = true, string $route = '/app', array $data = [])
```

- El primer parámetro, `$module`, es el módulo que deseas importar. Si este módulo no termina con una extensión PHP, importará todos los archivos dentro de esa carpeta. Si tiene la extensión PHP, importará ese archivo en particular.
- El segundo parámetro, `$return`, indica si deseas instanciar la clase de ese archivo o simplemente llamar al archivo.
- El tercer parámetro, `$route`, es la ruta raíz desde la cual buscará ese módulo.
- El cuarto parámetro, `$data`, es un array que se pasa a esa clase instanciada.

Ejemplo de uso:

```php
$encripter = import('/Encrypt/encrypt.php', true, '/core');
$stringEncript = $encripter->encrypt('hola', 'key');
```

Cuando se llama a `import()` y el segundo parámetro es `true`, puedes instanciar su clase de inmediato y utilizar sus funciones. Nota: Para obtener la clase del archivo, `import()` realiza lo siguiente:

```php
$module = deleteFormat(lastDir($dir));
```

Lo que significa que considera que el nombre del archivo es igual al nombre de la clase.

A partir de aquí, todos los demás Helpers de Sao ocupan esta función. Por ejemplo:

```php
function core($module, $return = true, $data = []){
    return import($module, $return, '/core', $data);
}

function csrf(){
    import('/server/csrf.php', false, '/core');
} 

function model($modelName){
    return import('Models/'.$modelName.".php");
}

// ... Otros métodos de importación ...
```

Hay algunos otros métodos como:

```php
function res(array $response, $code = 200, $errorResponseBody = null, $errorResponseHeader = null)
```
Este método envía una respuesta JSON y recibe un payload en forma de array.

```php
function serve($host = null)
```
Este método devuelve el host (aún en desarrollo).

```php
function route($route, $print = true)
```
Recibe una ruta como parámetro y devuelve la ruta completa (con host y protocolo) en la que te encuentras. Si el parámetro `$print` está en verdadero, se imprimirá; de lo contrario, se retornará.

## Helpers generales
Estos métodos se pueden usar en cualquier parte de la aplicación que se desarrolle.


### Arrays

Estas funciones son útiles para la manipulación de arrays:

```php
function sortIndex(array $array)
```

Ordena los índices de un array pasado como parámetro y devuelve el array ordenado.

- **$array**: El array que deseas ordenar.
- **Returns**: El array ordenado.

```php
function arrayToObject(array $array)
```

Convierte un array en un objeto y retorna dicho objeto.

- **$array**: El array que deseas convertir en objeto.
- **Returns**: Un objeto creado a partir del array.

```php
function isAssoc(array $array)
```

Verifica si el array pasado como parámetro es un array asociativo y retorna un booleano.

- **$array**: El array que deseas verificar.
- **Returns**: `true` si el array es asociativo, `false` si no lo es.

```php
function deleteElementArray(array $array, ...$indexes)
```

Elimina elementos de un array según los índices proporcionados y devuelve un nuevo array con los índices eliminados y ordenados utilizando `sortIndex`.

- **$array**: El array del cual deseas eliminar elementos.
- **...$indexes**: Índices que deseas eliminar.
- **Returns**: Un nuevo array con los índices especificados eliminados y ordenados.

### Console

Estas funciones están diseñadas para interactuar con la consola:

```php
function printColor($message, $color)
```

Imprime un mensaje en la consola con el color especificado utilizando códigos de color ANSI.

- **$message**: El mensaje que deseas imprimir.
- **$color**: El código de color en formato ANSI.
- **Output**: Muestra el mensaje en la consola con el color especificado.

```php
function consoleError($error)
```

Imprime un mensaje de error en la consola con el prefijo "Error:" en color rojo.

- **$error**: El mensaje de error que deseas imprimir.
- **Output**: Muestra el mensaje de error en la consola con el prefijo "Error:" en color rojo.

```php
function consoleWarning(string $warning, bool $start = true)
```

Imprime un mensaje de advertencia en la consola con color amarillo. Opcionalmente, puedes incluir un prefijo en el mensaje si el segundo parámetro, `$start`, está configurado como `true`.

- **$warning**: El mensaje de advertencia que deseas imprimir.
- **$start**: Un booleano que determina si se debe incluir un prefijo en el mensaje (predeterminado: `true`).
- **Output**: Muestra el mensaje de advertencia en la consola con color amarillo y, si está habilitado, con un prefijo.

### Files
Estos Helpers son útiles para realizar operaciones de lectura, escritura, copia y eliminación de archivos y directorios en tu aplicación. Puedes utilizarlos en diferentes partes de tu código para manejar archivos de manera eficiente.

```php
function readTxt($name){
```
Abre un archivo de texto y obtiene su contenido.

- **$name**: El nombre del archivo que deseas leer.
- **Returns**: El contenido del archivo.

```php
function format($file){
```
Obtiene la extensión de un archivo.

- **$file**: El nombre del archivo.
- **Returns**: La extensión del archivo.

```php
function lastDir($file){
```
Obtiene el nombre del directorio o archivo de un camino (path).

- **$file**: El camino del directorio o archivo.
- **Returns**: El nombre del directorio o archivo.

```php
function deleteFormat($file){
```
Obtiene el nombre del archivo sin su extensión.

- **$file**: El nombre del archivo.
- **Returns**: El nombre del archivo sin la extensión.

```php
function getFilesByDirectory($dir){
```
Obtiene una lista de archivos en un directorio.

- **$dir**: La ruta del directorio.
- **Returns**: Un array con los nombres de los archivos en el directorio.

```php
function getDirsFilesByDirectory($dir){
```
Obtiene la ruta completa de los archivos en un directorio.

- **$dir**: La ruta del directorio.
- **Returns**: Un array con las rutas completas de los archivos en el directorio.

```php
function showFiles($path){
```
Muestra una lista de archivos en un directorio y sus subdirectorios.

- **$path**: La ruta del directorio.
- **Returns**: Un array con los nombres de los archivos en el directorio y sus subdirectorios.

```php
function copyDirectory($source, $destination){
```
Copia un directorio y su contenido a otro destino.

- **$source**: La ruta del directorio de origen.
- **$destination**: La ruta del directorio de destino.

```php
function deleteDirectory($dir){
```
Elimina un directorio y su contenido.

- **$dir**: La ruta del directorio que deseas eliminar.

### Helpers de Objetos

Estas funciones son útiles para trabajar con objetos:

```php
function objectToArray(Object $object)
```

Convierte un objeto en un array asociativo utilizando la codificación y decodificación de JSON. Retorna el objeto convertido en formato de array.

- **$object**: El objeto que deseas convertir en un array.
- **Returns**: Un array asociativo que representa el objeto convertido.

### Helpers de Impresiones

Estas funciones son útiles para mostrar datos en la consola o en una página web:

```php
function printfa(...$data)
```

Imprime datos en la consola o en una página web. Concatena los datos pasados como argumentos y luego los muestra.

- **...$data**: Argumentos variables que se imprimirán.

```php
function prettyPrint($array, $json = false)
```

Realiza una impresión formateada de un array o de datos JSON en la consola o en una página web.

- **$array**: El array o datos JSON que deseas imprimir.
- **$json**: Un valor booleano que indica si los datos pasados son JSON o no (valor predeterminado: `false`).

**Nota**: En caso de que `$json` sea `true`, se imprimirá el contenido como JSON; de lo contrario, se mostrará utilizando `var_dump` con un formato más legible.

### Helpers de Strings

Estas funciones están diseñadas para trabajar con cadenas de texto:

```php
function randomString($length)
```

Genera un string aleatorio de la longitud especificada.

- **$length**: La longitud del string aleatorio que deseas generar.

```php
function token($length = 32)
```

Genera un token aleatorio, que suele utilizarse para autenticación o seguridad.

- **$length**: La longitud del token que deseas generar (valor predeterminado: `32`).

