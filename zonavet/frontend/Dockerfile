FROM node:24-alpine AS development
# Creamos la carpeta y le damos permisos al usuario node
RUN mkdir -p /frontend/node_modules /frontend/.angular && chown -R node:node /frontend
# Obligamos a que inicie con usuario node
USER node
WORKDIR /frontend


# TODO: Despues ver como hacer las otras stages.