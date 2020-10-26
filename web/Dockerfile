FROM node:12.8-alpine

WORKDIR /node-app

COPY ./package*.json ./

RUN npm i

COPY . .

EXPOSE 8080 4000

CMD ["npm", "run", "concurrently:dev:ui"]
