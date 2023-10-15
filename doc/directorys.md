# Estructura de Directorios

## /app
Esta carpeta contiene toda tu aplicación y se divide en 6 carpetas adicionales.

### /console
En esta carpeta, encontrarás un archivo llamado `console.php`. Aquí podrás definir los comandos necesarios para ejecutarlos posteriormente con la aplicación de comandos de Sao, llamada `jenu`.

### /Controllers
Aquí se definen todos los controladores de tu aplicación, que pueden provenir de las solicitudes (request) o de otras fuentes.

### /DataBase
Dentro de esta carpeta, encontrarás la subcarpeta:

#### /migrations
En esta subcarpeta se almacenan todas tus migraciones (tablas) para la base de datos. Para crear una migración, ejecuta:

```sh
php jenu make:migration nombre_de_tu_migración
```

### /middlewares
En esta carpeta, puedes crear todos los middlewares de tu aplicación, ya sea para la gestión de sesiones, roles, etc. Estos middlewares se aplicarán a las rutas (no a las vistas).

### /Models
Aquí se encuentran todos los modelos de tu base de datos. Básicamente, esta capa está más relacionada con la base de datos. Cada archivo en /Models representa una tabla y puede servir como controlador de tablas.

### /Views
Esta carpeta es donde puedes crear todos tus archivos de vistas para tu aplicación. Dentro de ella, hay una subcarpeta ya creada llamada:

#### /layouts
La carpeta de "layouts" te permite almacenar partes (renders) de las vistas que se repiten en todas las páginas, como encabezados, pies de página y elementos estáticos que son comunes en el sitio web. Esto te permite reutilizarlos desde las vistas.