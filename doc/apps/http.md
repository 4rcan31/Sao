# HTTP - Aplicación de Request and Response de Sao

La aplicación de HTTP se divide en dos componentes fundamentales: Request (solicitud) y Response (respuesta). Estos elementos son esenciales para el procesamiento de solicitudes y respuestas en una aplicación web.

## Request

La Request, o solicitud, se encarga de capturar información importante cuando un cliente ingresa a una ruta en la aplicación. Esta información se almacena para su posterior acceso en cualquier parte de la aplicación. Los datos capturados incluyen:

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

Los datos capturados son esenciales para comprender y procesar las solicitudes del usuario. Esto permite que la aplicación web responda de manera adecuada a las interacciones del cliente.

## Response

Aunque la aplicación de Response aún no está completamente desarrollada, es posible utilizar la función `res()` de los helpers. Esta función está diseñada para gestionar la generación de respuestas, lo que incluye la entrega de contenido al cliente en función de las solicitudes previamente procesadas. Esta funcion como parametro se le pasa un array, y imprime como json como respuesta