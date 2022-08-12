FROM node:alpine as base
WORKDIR /home/node/app/

COPY package*.json ./
EXPOSE 8080

FROM base as builder

RUN npm install --only=production
RUN cp -R node_modules production_dependencies

RUN npm install

COPY . ./

RUN npm run build

FROM base as production

COPY --from=builder /home/node/app/production_dependencies ./node_modules
COPY --from=builder /home/node/app/dist ./dist
COPY --from=builder /home/node/app/entrypoint.sh ./

ENTRYPOINT ["/home/node/app/entrypoint.sh"]

FROM base as development

COPY --from=builder /home/node/app/ ./

CMD npm run serve
