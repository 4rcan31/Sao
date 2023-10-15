# View - Aplicación de vistas de Sao

El módulo de Vistas se encuentra en una fase de desarrollo activo, y está en constante evolución con numerosas ideas para mejorar su implementación. Este módulo se divide en múltiples componentes, que incluyen: `Form`, `Requires`, `ViewData`, `CoreJavaScript`, `Layouts`, `htmlBuilt`. Cuando se utiliza la función `view()` para invocar una vista, se realiza la carga de todos estos componentes necesarios para el funcionamiento de la aplicación de vistas.

## Form
Esta librería, diseñada para la manipulación de formularios y la entrega de notificaciones, aún se encuentra en desarrollo, lo que significa que algunas de sus características son estáticas. La clase Form desempeña un papel fundamental en la gestión de formularios en una aplicación PHP. Esta clase proporciona una serie de métodos para facilitar el envío, recuperación y visualización de datos de formularios, además de ofrecer funciones útiles para la administración de estos formularios.

### Propiedades

- **$inputs**: Un array que almacena la información de los campos de entrada del formulario.
- **$data**: Almacena temporalmente los datos del formulario para su uso.

### Métodos

#### `send`

```php
public static function send(string $route, array $data, $type)
```

Este método envía datos a una ruta específica después de codificarlos en formato JSON y base64. Para obtener esos datos utiliza el metodo `get`

- **$route**: La ruta a la que se enviarán los datos.
- **$data**: Un array que contiene los datos.
- **$type**: Un tipo que se utilizará como parte del encabezado de los datos.

#### `isThere`

```php
public static function isThere()
```

Verifica si hay datos almacenados en algun envio.

#### `get`

```php
public static function get($json = false)
```

Obtiene los datos almacenados y los decodifica, devolviendo un objeto o un JSON.

- **$json**: Si se establece en `true`, se devuelve un JSON en lugar de un objeto.

#### `print`

```php
public static function print()
```

Imprime los datos almacenados como notificaciones en formato de toasts.

#### `setValuesInputs`

```php
public static function setValuesInputs()
```

Asigna valores a los campos de entrada en el formulario basados en los datos almacenados en la sesión.

#### `destroyData`

```php
public static function destroyData()
```

Elimina los datos almacenados en la sesión.

#### `setInputs`

```php
public static function setInputs($inputs)
```

Establece los campos de entrada del formulario y los almacena en la sesión.

- **$inputs**: Un array que contiene información sobre los campos de entrada del formulario.

#### `toast`

```php
public static function toast(string $title, string $body, $id, $delay, $verticalOffset, $toastHeight, $time = 'now', $img = '')
```

Genera una notificación estilo toast que se puede imprimir en la página.

- **$title**: El título de la notificación.
- **$body**: El cuerpo del mensaje de la notificación.
- **$id**: Un identificador único para la notificación.
- **$delay**: El retraso en milisegundos antes de mostrar la notificación.
- **$verticalOffset**: La posición vertical de la notificación.
- **$toastHeight**: La altura de la notificación.
- **$time**: La hora de la notificación (opcional).
- **$img**: La URL de una imagen a mostrar junto al mensaje (opcional).

#### `getToastHeight`

```php
public static function getToastHeight($content)
```

Calcula la altura adecuada para una notificación estilo toast basada en la longitud del contenido del mensaje.

#### `addInput`

```php
public static function addInput($name, $type, $label, $class, $placeholder = '', $id = '', $value = '')
```

Agrega un campo de entrada al formulario.

- **$name**: El nombre del campo.
- **$type**: El tipo del campo (por ejemplo, text, password, etc.).
- **$label**: La etiqueta del campo.
- **$class**: Las clases CSS para el campo.
- **$placeholder**: El texto de marcador de posición para el campo (opcional).
- **$id**: El identificador HTML del campo (opcional).
- **$value**: El valor predeterminado para el campo (opcional).

#### `addTextArea`

```php
public static function addTextArea(string $name, $label, $class, $rows = 3, $classLabel = "form-label", $placeholder = '', $id='', $value="")
```

Agrega un área de texto al formulario.

- **$name**: El nombre del área de texto.
- **$label**: La etiqueta del área de texto.
- **$class**: Las clases CSS para el área de texto.
- **$rows**: El número de filas en el área de texto (opcional, valor predeterminado: 3).
- **$classLabel**: Las clases CSS para la etiqueta del área de texto (opcional, valor predeterminado: "form-label").
- **$placeholder**: El texto de marcador de posición para el área de texto (opcional).
- **$id**: El identificador HTML del área de texto (opcional).
- **$value**: El valor predeterminado para el área de texto (opcional).

#### `PrintInputs`

```php
public static function PrintInputs()
```

Imprime los campos de entrada definidos en el formulario.

#### `processInputs`

```php
public static function processInputs($request)
```

Procesa los campos de entrada enviados en la solicitud y los almacena en un formato adecuado en la sesión.

--- 
## Layouts

El módulo "Layouts" es esencial para la gestión de archivos que se repiten en todas las vistas de una aplicación, como encabezados, pies de página, barras laterales y otros componentes similares. Este módulo consta de dos funciones clave para facilitar la inclusión de estos elementos en las vistas.

### Función `layouts`

```php
function layouts()
```

La función `layouts` cumple la función de importar y cargar todos los diseños o layouts disponibles en la carpeta `app/view/layouts`. Su principal objetivo es proporcionar una forma sencilla y conveniente de utilizar estos diseños en las vistas de la aplicación. Esta función está diseñada para llamarse típicamente desde una vista, permitiendo una integración más fluida de los diseños en el proceso de renderizado.

### Función `layout`

```php
function layout($file, $format = 'php')
```

En caso de que no se necesite importar todos los layouts disponibles, la función `layout` ofrece una solución más selectiva. Permite importar un diseño específico desde la carpeta `app/view/layouts`. Al llamar a esta función, se cargarán y aplicarán las características del diseño seleccionado. La estructura de llamada para esta función sigue un patrón predecible, donde el archivo del diseño a importar se concatena con la ruta base de la carpeta de diseños (`app/view/layouts`). El formato por defecto es PHP, aunque se puede especificar otro formato si es necesario.

---

## Requires

En la gestión de archivos estáticos, estos se llaman desde la carpeta `/public`. Aquí se presenta un ejemplo de cómo incluir archivos en la sección `<head>` de una página, junto con las funciones que hacen esto posible. Ejemplo:

```php
<?php
//Esto es app/views/layouts/head.php
function head($title) {
    ?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta http-equiv="Content-Type" content="text/html">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title ?></title>
        <?php requiresStaticFiles([
            routePublic('vendor/bootstrap/css/bootstrap.min.css'),
            routePublic('assets/css/style.css'),
        ]) ?>
    </head>
    <?php
}
```
 La función `requiresStaticFiles` se encarga de gestionar la inclusión de archivos estáticos, ya sea hojas de estilo o scripts.

### Función `requiresStaticFiles`

```php
function requiresStaticFiles($files = [], string $type = 'text/javascript')
```

La función `requiresStaticFiles` recibe un array de archivos estáticos que se requieren en la página. Pueden ser archivos de diferentes tipos, como hojas de estilo CSS o scripts JavaScript. Dependiendo del tipo de archivo, esta función genera automáticamente la etiqueta HTML correspondiente, ya sea para hojas de estilo (`<link>`) o para scripts (`<script>`).

### Función `routePublic`

```php
function routePublic(string $route)
```

La función `routePublic` se utiliza para obtener la ruta completa a un archivo estático ubicado en la carpeta `/public`. Esto es fundamental para asegurarse de que los archivos estáticos se incluyan correctamente en la página. La función construye la URL completa, incluyendo el protocolo, dominio y ruta relativa al archivo estático.

### Ejemplo más Amplio

```php
function scripts() {
    Form::print();
    Form::setValuesInputs();
    Form::destroyData();
    echo requiresStaticFiles([
        routePublic('vendor/jquery/jquery.min.js'),
        routePublic('vendor/bootstrap/js/bootstrap.bundle.min.js'),
        routePublic('vendor/jquery-easing/jquery.easing.min.js'),
        routePublic('assets/js/sb-admin-2.min.js'),
        routePublic('vendor/chart.js/Chart.min.js'),
        routePublic('assets/js/demo/chart-area-demo.js'),
        routePublic('assets/js/demo/chart-pie-demo.js'),
        routePublic('vendor/datatables/jquery.dataTables.min.js'),
        routePublic('vendor/datatables/dataTables.bootstrap4.min.js')
    ]);
}
```

Este ejemplo más amplio demuestra cómo se pueden cargar múltiples archivos estáticos, incluyendo scripts y hojas de estilo, utilizando las funciones previamente mencionadas. Todos estos archivos se cargarán desde la carpeta `/public` y se incorporarán en la página, asegurando su correcta inclusión y funcionamiento.


## ViewData

El módulo ViewData es una herramienta para recuperar datos que se han pasado como segundo parámetro cuando se ejecutó la función `view()`. Esto permite acceder a los datos que se utilizan en una vista específica. Aquí se presenta cómo utilizar este módulo:

### Función `get`

Para obtener los datos pasados a través de la función `view()`, puedes utilizar la función `get()` proporcionada por el módulo ViewData. La función se utiliza de la siguiente manera:

```php
public static function get()
```

**Ejemplo de Uso:**

```php
// Uso de la función get() para obtener los datos
$data = ViewData::get();
```

La variable `$data` ahora contiene todos los datos que se pasaron al llamar a la función `view()`. Esto es esencial para acceder y utilizar los datos necesarios en la vista correspondiente.

## CoreJavaScript

El módulo CoreJavaScript es una pequeña biblioteca de lado del cliente que aún se encuentra en desarrollo. A pesar de su estado en desarrollo, esta biblioteca ofrece una serie de funcionalidades que son funcionales para la interacción del lado del cliente en una aplicación web. A continuación, se presenta una descripción general de esta biblioteca y cómo utilizarla.

### Función `requireCore`

Para utilizar las funcionalidades proporcionadas por la biblioteca CoreJavaScript, debes ejecutar la función `requireCore()`. Esta función internamente requiere varios archivos necesarios para habilitar diversas características de la biblioteca. Aquí se muestra cómo utilizar esta función:

```php
function requireCore()
```

**Ejemplo de Uso:**

```php
// Llamada a la función requireCore() para habilitar la biblioteca CoreJavaScript
requireCore();
```

La función `requireCore()` es un paso fundamental para acceder a las funciones y características ofrecidas por esta biblioteca.

### Archivos Incluidos

Los archivos necesarios para la biblioteca CoreJavaScript se encuentran en la carpeta `public/core`. A continuación, se enumeran los archivos incluidos:

- **document.js**: Proporciona funciones relacionadas con la manipulación del DOM y la gestión de elementos en la página web.

- **touch.js**: Ofrece detección y gestión de gestos táctiles en áreas específicas de la pantalla.

- **cookies.js**: Permite la gestión de cookies en el navegador, lo que es útil para almacenar datos localmente.

- **server.js**: Proporciona funciones para realizar redirecciones y manipular la ubicación del navegador.

- **string.js**: Ofrece funcionalidades relacionadas con el manejo y manipulación de cadenas de texto.


Esta estructura proporciona una descripción organizada del módulo CoreJavaScript, su función `requireCore`, y los archivos incluidos, lo que facilita la comprensión y el uso de esta biblioteca en el desarrollo de aplicaciones web.

### document.js

1. **hide(elementId)**
   - Descripción: Esta función oculta un elemento en la página web con el ID especificado. Establece el estilo `display` del elemento en `'none'`.
   - Parámetros:
     - `elementId` (String): El ID del elemento que se desea ocultar.
   - Ejemplo de uso:
     ```javascript
     hide('miElemento'); // Oculta el elemento con ID 'miElemento'.
     ```

2. **show(elementId)**
   - Descripción: Esta función muestra un elemento oculto en la página web con el ID especificado. Establece el estilo `display` del elemento en `'block'`.
   - Parámetros:
     - `elementId` (String): El ID del elemento que se desea mostrar.
   - Ejemplo de uso:
     ```javascript
     show('miElemento'); // Muestra el elemento con ID 'miElemento'.
     ```

3. **isHide(elementId)**
   - Descripción: Esta función verifica si un elemento con el ID especificado está oculto. Retorna `true` si el elemento está oculto (`display` es `'none'`), de lo contrario, retorna `false`.
   - Parámetros:
     - `elementId` (String): El ID del elemento que se desea verificar.
   - Ejemplo de uso:
     ```javascript
     if (isHide('miElemento')) {
         console.log('El elemento está oculto.');
     } else {
         console.log('El elemento no está oculto.');
     }
     ```

4. **isShow(elementId)**
   - Descripción: Esta función verifica si un elemento con el ID especificado está visible. Retorna `true` si el elemento no está oculto (`display` no es `'none'`), de lo contrario, retorna `false`.
   - Parámetros:
     - `elementId` (String): El ID del elemento que se desea verificar.
   - Ejemplo de uso:
     ```javascript
     if (isShow('miElemento')) {
         console.log('El elemento está visible.');
     } else {
         console.log('El elemento está oculto.');
     }
     ```

5. **display(elementId)**
   - Descripción: Esta función retorna el valor actual de la propiedad `display` de un elemento con el ID especificado, lo que indica si está oculto o visible.
   - Parámetros:
     - `elementId` (String): El ID del elemento del que se desea obtener el estado de visualización.
   - Valor de retorno: Una cadena que representa el valor de la propiedad `display` del elemento.
   - Ejemplo de uso:
     ```javascript
     var estado = display('miElemento');
     console.log('El estado de visualización es: ' + estado);
     ```
### cookies.js

1. **setCookie(name, value)**
   - Descripción: Esta función se utiliza para establecer una cookie en el navegador del usuario. Las cookies son pequeños fragmentos de información que se almacenan localmente en el navegador y se pueden utilizar para recordar datos entre sesiones o visitas al sitio web.
   - Parámetros:
     - `name` (String): El nombre de la cookie.
     - `value` (String): El valor que se almacenará en la cookie.
   - Ejemplo de uso:
     ```javascript
     setCookie('miCookie', 'miValor'); // Establece una cookie llamada 'miCookie' con el valor 'miValor'.
     ```

2. **getCookie(name)**
   - Descripción: Esta función se utiliza para obtener el valor de una cookie específica por su nombre.
   - Parámetros:
     - `name` (String): El nombre de la cookie de la que se desea obtener el valor.
   - Valor de retorno: El valor de la cookie si se encuentra, o `null` si la cookie no existe.
   - Ejemplo de uso:
     ```javascript
     var valor = getCookie('miCookie'); // Obtiene el valor de la cookie llamada 'miCookie'.
     if (valor !== null) {
         console.log('Valor de la cookie: ' + valor);
     } else {
         console.log('La cookie no existe.');
     }
     ```

### touch.js

**touch(selector, leftCallable = null, rightCallable = null, upCallable = null, downCallable = null)**
- **Descripción**: La función `touch` permite detectar gestos táctiles en un área específica de la pantalla y ejecutar funciones personalizadas en respuesta a diferentes gestos, como deslizar hacia la izquierda, hacia la derecha, hacia arriba o hacia abajo. Puede proporcionar funciones personalizadas que se ejecutarán cuando ocurran los gestos especificados.
- **Parámetros**:
  - `selector` (String): El selector CSS que define el área donde se detectarán los gestos táctiles.
  - `leftCallable` (Función, opcional): La función que se ejecutará cuando se detecte un deslizamiento hacia la izquierda.
  - `rightCallable` (Función, opcional): La función que se ejecutará cuando se detecte un deslizamiento hacia la derecha.
  - `upCallable` (Función, opcional): La función que se ejecutará cuando se detecte un deslizamiento hacia arriba.
  - `downCallable` (Función, opcional): La función que se ejecutará cuando se detecte un deslizamiento hacia abajo.
- **Uso**:
  - Para utilizar esta función, proporciona un selector CSS que identifique el área de la pantalla en la que se deben detectar los gestos táctiles.
  - Puedes proporcionar funciones personalizadas (`leftCallable`, `rightCallable`, `upCallable` y `downCallable`) que se ejecutarán cuando ocurran los gestos correspondientes.
- **Ejemplo de uso**:
  ```javascript
  // Ejemplo 1: Detecta gestos táctiles en un elemento con clase "area-tactil"
  touch("area-tactil", () => {
      console.log("Deslizamiento hacia la izquierda");
  }, () => {
      console.log("Deslizamiento hacia la derecha");
  }, () => {
      console.log("Deslizamiento hacia arriba");
  }, () => {
      console.log("Deslizamiento hacia abajo");
  });
  
  // Ejemplo 2: Detecta gestos táctiles en un elemento con clase "otra-area-tactil" (sin funciones personalizadas)
  touch("otra-area-tactil");
  ```

## server.js

**redirectTo(page)**
- **Descripción**: La función `redirectTo` redirige al usuario a una página web específica al cambiar la ubicación del navegador a la URL especificada en `page`. Esto se logra modificando la propiedad `window.location.href`.
- **Parámetros**:
  - `page` (String): La URL de la página a la que se desea redirigir al usuario.
- **Uso**:
  - Proporciona la URL de la página a la que deseas redirigir al usuario.
- **Ejemplo de uso**:
  ```javascript
  // Redirige al usuario a la página "nueva-pagina.html"
  redirectTo("nueva-pagina.html");
  ```

**thisUrl()**
- **Descripción**: La función `thisUrl` retorna la URL actual de la página web en la que se encuentra el usuario. Esto se logra obteniendo la propiedad `window.location`.
- **Retorno**: La función retorna un objeto `Location` que representa la URL actual de la página.
- **Uso**:
  - Puedes llamar a esta función para obtener la URL actual del navegador.
- **Ejemplo de uso**:
  ```javascript
  // Obtiene la URL actual y la muestra en la consola
  const currentUrl = thisUrl();
  console.log(currentUrl.href);
  ```


### Strings.js

**randomString(length)**
- **Descripción**: La función `randomString` genera una cadena de caracteres aleatorios de la longitud especificada. La cadena incluye caracteres alfabéticos en mayúsculas y minúsculas, así como dígitos numéricos.
- **Parámetros**:
  - `length` (Number): La longitud de la cadena aleatoria que se debe generar.
- **Retorno**: La función retorna una cadena de caracteres aleatorios con la longitud especificada.
- **Uso**:
  - Proporciona la longitud deseada para la cadena aleatoria que deseas generar.
- **Ejemplo de uso**:
  ```javascript
  // Genera una cadena aleatoria de 10 caracteres
  const randomValue = randomString(10);
  console.log(randomValue);
  ```


## htmlBuilt

La funcionalidad "htmlBuilt" es una característica que permite utilizar PHP para generar código HTML de manera dinámica. Esto se basa en la idea de que el HTML no es más que texto y, al igual que con las consultas SQL, se pueden utilizar estructuras de control como bucles y condiciones para generar código HTML de manera más eficiente y organizada.

### Estructura de las Funciones de HTML

Las funciones de HTML siguen una estructura específica:

```php
nameEtiqueta(string $principioOFin, Array $attributes = []);
```

- `nameEtiqueta`: Reemplaza "Etiqueta" por el nombre de la etiqueta HTML que deseas generar.
- `$principioOFin`: Debe ser "s" para el inicio (start) de la etiqueta o "e" para el final (end).
- `$attributes`: Es un arreglo opcional que contiene los atributos de la etiqueta.

Por ejemplo, si deseas abrir una etiqueta `div`, usarías la función `div('s', $attributes)` para el inicio y `div('e')` para el final. Esto permite generar HTML de manera más estructurada y legible.

### Añadir Atributos a las Etiquetas

Los atributos se pueden especificar mediante el arreglo `$attributes`. Puedes proporcionar varios atributos dentro de este arreglo para personalizar tu etiqueta HTML. Por ejemplo:

```php
div('s', [
    'class' => 'container',
    'id' => 'NameIdDivContainer'
]);
```

También es posible definir los atributos en una sola línea, como se muestra a continuación:

```php
div('s', [
    'class="container" id="NameId"'
]);
```

Este enfoque facilita la personalización de las etiquetas HTML con los atributos necesarios.

### Personalización de Etiquetas HTML

Si no encuentras una función predefinida para la etiqueta HTML que deseas, puedes crear tu propia función personalizada. Simplemente utiliza la función `newHtml()` para definir la etiqueta y sus atributos. Para hacerlo, consulta el archivo `core/Views/html.php`, donde encontrarás una estructura que te guiará en la creación de tus propias funciones de etiquetas HTML.

La funcionalidad "htmlBuilt" ofrece una forma más eficiente y organizada de generar código HTML dinámico utilizando PHP y estructuras de control. Esta técnica resulta especialmente útil cuando necesitas generar HTML complejo o repetitivo.