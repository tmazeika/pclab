# --- !Ups

CREATE TABLE IF NOT EXISTS components (
  id SERIAL,
  name VARCHAR(255) NOT NULL,

  PRIMARY KEY (id)
);

# --- !Downs

DROP TABLE IF EXISTS components;
