# Aplicaciones de Sao

Sao cuenta con aplicaciones tanto internas como externas. Puedes consultar las librerías externas utilizadas en el archivo `composer.json`. Las aplicaciones internas se encuentran en la carpeta `/core` y comprenden las siguientes:

- `Auth`: Permite autenticar cualquier entidad que ingrese al programa.
- `Jenu`: Consola de Sao.
- `Console`: Es la aplicación de consola llamada Jenu.
- `DataBase`: Contiene el código para el constructor de consultas y la conexión a la base de datos.
- `Encrypt`: Incluye aplicaciones para encriptar y hashear datos.
- `Helpers`: Ofrece funciones genéricas, algunas diseñadas exclusivamente para Sao y otras de uso general.
- `Http`: Contiene librerías relacionadas con la aplicación del request y el response.
- `Resources`: Es una librería para gestionar archivos subidos.
- `Routing`: Representa la aplicación más importante de Sao, que implementa el algoritmo de enrutamiento.
- `Server`: Proporciona funciones generales para el servidor.
- `Time`: Contiene librerías para el manejo del tiempo.
- `Validate`: Ofrece el validador de datos de Sao.
- `Views`: Proporciona librerías para el manejo de vistas.


Algunas de estas librerías no necesitarás importarlas explícitamente utilizando las funciones `import()` o `core()` (las cuales serán explicadas más adelante en la sección de "Helpers"). Esto se debe a que estas librerías ya han sido autoimportadas en el cargador automático de Sao. A continuación, se presenta la lista de todas las librerías que se han importado automáticamente:

```php
$this->runAppSession();
$this->runAppHelpers();
$this->runAppSaoHelpers();
$this->runAppAutoloaderComposer();
$this->runAppServe();
$this->runAppHttp();
$this->runAppRouting();
$this->runAppAuth();
$this->runAppApp();
$this->runAppRoutes();
```

Si deseas examinar o realizar modificaciones en el cargador automático de Sao, puedes encontrarlo en el archivo `core/app.php`.


