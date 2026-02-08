#!/bin/bash
set -x
# Si no existe .env lo genera y genera APP_KEY en el .env
if [ ! -f ./backend/.env ]; then
    cp ./backend/.env.example ./backend/.env
    # Generamos APP_KEY
    sed -i "s/APP_KEY=/APP_KEY=base64:$(openssl rand -base64 32)/" ./backend/.env
fi

# Levantamos todo con docker compose, haciendo build y en segundo plano (-d)
docker compose up --build -d