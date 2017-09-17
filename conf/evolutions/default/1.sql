# --- !Ups

CREATE TABLE form_factors (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE sockets (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);

# --- !Downs

DROP TABLE form_factors, sockets;
