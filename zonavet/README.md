# ZONAVET - GRUPO 11 
- Kevin
- Alex Molina
- Jorge Melnik


# Levantar entorno de desarrollo.
Usar docker, docker compose y un archivo generado por nosotros nos ayuda a entender de una mejor manera que servicios se están utilizando y para que. Por eso preferimos esta forma sobre usar sail, pero mantenemos la facilidad que nos brinda un docker compose file.
Todas las imágenes de docker utilizadas con la versión alpine para que sea más rápido levantar y bajar el ambiente repetidamente.

## Requisitos previos para levantar con docker.
- Docker y docker compose (versiones modernas de docker lo traen) instalados.
- Usar docker compose y no docker-compose (si estuviera disponible esta versión antigua)
- Si no funciona docker compose, hay que actualizar docker a una versión nueva.

## Pasos a seguir: 
- clonar repositorio o descomprimir archivo zip
- ingresar a carpeta zonavet
- ```sh up.sh```

## Servicios disponibles:

### proxy
Un servicio con imagen base nginx para levantar un reverse proxy. 
La configuración la tenemos en proxy/default.conf y la inyectamos en el contenedor mediante un volumen. 
Loo que hace este servicio es que las peticiones a / las envía al servicio frontend:4200 que es el servidor de desarrollo de angular. Las peticiones a /api las envía al servicio backend. En ambos casos devuelve la respuesta del servicio correspondiente. 
Este servicio proxy nos evita configurar cors en el servidor backend.
Esto nos permite acceder al frontend en: http://localhost y al backend en http://localhost/api  


### frontend
Es el servicio con el proyecto angular. Al iniciar el servicio, por las dudas, se instalan las dependencias antes de ejecutar el servidor de desarrollo. Si se instala alguna nueva dependencia, es posible que sea necesario reiniciar el servicio.
Además a este servicio le configuramos los siguientes volúmenes:
- ./frontend: Volumen para "colocar" nuestro código fuente en la carpeta dentro del contenedor. De esta forma no tenemos que abrir vscode conectado al contenedor.
-  zonavetnode_modules: Volumen nombrado para evitar que me cree la carpeta node_modules en el host. Se usa un volumen nombrado dentro del sistema docker y será más eficiente.
- zonavet.angular: Idem anterior para la carpeta de cache de angular, que aveces es necesario borrar.
No es necesario exponer puerto ya que lo accedemos a travez del proxy.

### backend
Es el servicio con el proyecto de una api laravel. En este proyecto se borró todo lo relacionado (que identificamos) a frontend para que trabaje únicamente como una api rest. Este servicio tiene que esperar a que esté disponible el servicio de la base de datos y que la base de datos sea accesible. Por eso pusimos un depends_on con healt_check en el servicio de la bd.
Al iniciar este servicio se instalan las dependencias en previsión que un pull de cambios de un compañero traiga nuevas dependencias y además ejecutamos las migraciones y seeders antes de levantar el servidor de desarrollo. Habrá que tener ``cuidado de no crear datos repetidos con los seeders en tablas donde hay claves únicas``. 
También usamos volumenes con la misma lógica que en el servicio frontend.
No es necesario exponer puerto ya que lo accedemos a travez del proxy.

### db
Servicio con base de datos postgres. Se define un volumen para los datos. Si queremos borrar los datos porque cambiamos la estructura y quiero ejecutar todas las migraciones desde cero, se debe parar todos los servicios con ```sh down.sh -v```` y al volver a levantar estará todo 0Km.
Se toman las variables de entorno necesarias del .env que existe en el backend. Se le agregaron las variables de entorno que espera recibir postgres.

## Networks:
- front para servicios proxy y frontend (por lo que frontend)
- backend para los servicios de la api y db.

## Scripts disponibles
Si ya se ejecutó una vez up.sh y existe el .env en backend con su correspondiente APP_KEY, no es necesario usar estos scripts y se puede utilizar docker compose normalmente. De todas formas, con los scripts hay que escribir menos.
Los scripts disponibles para facilitarnos las tareas de "encender" y "apagar" los servicios son:
- ```sh up.sh```: Levanta todos los servicios con docker compose y genera el .env y APP_KEY si es necesario.
- ```sh down.sh```: Detiene todos los contenedores. Si le pasamos -v borra los volúmenes creados, sino no.
- ```docker volume ls``` Si queremos saber si los volumenes están creados.
- ```docker volume prune``` Si queremos borrar los volumenes anónimos que no están en uso para liberar espacio.
- ```docker volume prune -a``` Si queremos borrar los volumenes anónimos que no están en uso para liberar espacio. Idem anterior pero también borra todos los volumenes nombrados que no están actualmente en uso. Con ```sh down -v``` podemos borrar los volumenes nombrados de nuestros servicios.


# Directorios y archivos principales
- backend: Proyecto de backend laravel solo api.
- frontend: Proyecto frontend angular
- proxy: configuración para proxy reverso con nginx evitando uso de cors en el servidor backend.
- docker-compose.yaml: Archivo de configuración para configurar los servicios que utilizaremos.
- down.sh: Permite bajar facilmente todos los servicios manteniendo o borrando los volúmenes nombrados (-v). Si borramos los volumenes nombrados, para la próxima se van a recrear las carpetas node_modules, vendor, .angular (¿y la base de datos?)
- up.sh: Nos permite levantar todos los servicios con un único comando para trabajar en el proyecto.
