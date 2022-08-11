#!/bin/sh

RUNTIME_CONFIG_DEFINITION='window.runtimeConfig = { \
  "VUE_APP_API_URL":"'"${VUE_APP_API_URL}"'" \
}'

sed -i "s@// RUNTIME_CONFIG_DEFINITION@${RUNTIME_CONFIG_DEFINITION}@" /home/node/app/dist/index.html
exec "$@"

npm run start
