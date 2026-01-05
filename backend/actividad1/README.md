# Usar con docker (Recomendado)

## Prerequisitos
- docker
- docker compose

## Iniciar entorno con driver = mysql | pgsql
- ```docker compose -f docker-compose-[driver].yaml up -d```
- Abrir el navegador e ingresar a la url localhost:8080

## Bajar entorno con driver = mysql | pgsql
```docker compose -f docker-compose-[driver].yaml down```

# Usar sin docker

## Prerequisitos
- Servidor apache con: 
    - php 
    - driver correspondiente a la base de datos
    - Módulo rewrite habilitado (para interpretar los .htaccess).
- Base de datos vacía disponible

## Instrucciones
- Copiar la carpeta web a la carpeta html de apache. El Dockerfile no sería necesario, pero si los .htaccess y todo lo demás.
- Apache debe servir el sitio en "/", por ejemplo, localhost:8080/, 
- Configurar las siguientes variables de entorno para la instancia de apache:  
    - DB_HOST: La ip o dominio del servidor donde se accede a la base de datos.
    - DB_DATABASE: Nombre de la base de datos ya creada.
    - DB_USER: Nombre del usuario ya existente para conectarnos a la base de datos.
    - DB_PASSWORD: Contraseña asociada al usuario anterior.
    - DB_PORT: Puerto de conexión a la base de datos.
    - DB_DRIVER: Driver mysql o pgsql según corresponda.
- Ejecutar en la base de datos el script db/[driver]/00_init.sql para crear las tablas.
- Ejecutar en la base de datos el script db/[driver]/01_data.sql para insertar los datos de prueba.

