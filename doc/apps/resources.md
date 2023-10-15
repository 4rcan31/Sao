# File - Aplicación de archivos de Sao

La librería "File" de Sao se utiliza para gestionar archivos subidos a través del request. A continuación, se describen los pasos para usar esta librería:

## Configuración Inicial

1. **Setear el archivo subido:**

   Para comenzar, debes configurar el archivo subido utilizando el siguiente método:

   ```php
   public static function setFile(array|object $file, $host = null)
   ```

   - `$file` es el objeto que proviene del `$request`.
   - Esta función devuelve un valor booleano, ya que el archivo pasa por una serie de filtros para verificar que no sea malicioso.

2. **Atributos Seguros:**

   La librería comprueba que el archivo tenga los siguientes atributos seguros:

   - Formatos permitidos: `['jpg', 'jpeg', 'png', 'gif']`.
   - Tipos MIME seguros: `['image/jpeg', 'image/png', 'image/gif']`.

   Si deseas configurar formatos permitidos personalizados, puedes utilizar el método:

   ```php
   public static function setAllowedFormats(array $formats)
   ```

   Si deseas establecer tipos MIME permitidos personalizados, puedes utilizar el método:

   ```php
   public static function setSafeMimeTypes(array $mimes)
   ```

3. **Setear el Host:**

   Puedes especificar el host para definir dónde se almacenarán los archivos subidos en el servidor. Esto se hace con el siguiente método:

   ```php
   public static function setHost(string $host)
   ```

## Subir Archivos

Una vez que has configurado los atributos del archivo y el host, puedes subir el archivo utilizando el método `upload`:

```php
public static function upload($nameFile = null, $ruteServer = 'public/uploads', $ruteHost = '/uploads')
```

- Si no especificas el primer parámetro (`$nameFile`), el método `upload` generará un nombre aleatorio para el archivo.
- El segundo parámetro (`$ruteServer`) define la ubicación en el servidor donde se guardarán los archivos.
- El tercer parámetro (`$ruteHost`) especifica la ruta en la parte del cliente desde la cual se accederá a los archivos subidos.

Este método devuelve un valor booleano, `true` si el archivo se ha subido con éxito y `false` en caso de error.

## Obtener Información del Último Archivo Subido

El método `lastFileUploadInfo` te permite obtener información sobre el último archivo subido. Puedes especificar un parámetro para obtener un dato específico o, si no se proporciona ningún parámetro, se te devolverá toda la información del archivo. Los parámetros disponibles son:

- `name`: Obtiene el nombre del archivo.
- `path:upload`: Obtiene la ruta en el servidor (sin el nombre del archivo).
- `host:upload`: Obtiene la ruta completa en el host (incluyendo el nombre del archivo).
- `rute:upload`: Obtiene la ruta en el servidor (sin el host).

## Ejemplo de Implementación

Aquí hay un ejemplo de cómo implementar esta librería para subir un archivo y actualizar el avatar de un usuario:

```php
if (!File::setFile($request['avatar'])) {
    res('Tu archivo es inválido o corrupto');
    File::setHost(serve($_ENV['APP_ADDRESS'].":".$_ENV['APP_PORT']));
    if (File::upload()) {
        $this->userModel()->updateAvatar(File::lastFileUploadInfo('rute:upload'), $idUser);
        Server::redirect('/panel/profile');
    }
}
```

Con esta estructura, puedes administrar fácilmente archivos subidos en tu aplicación Sao.