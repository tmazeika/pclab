# --- !Ups

INSERT INTO form_factors (name) VALUES
  ('ATX'), ('E-ATX'), ('Micro-ATX'), ('Mini-ITX');

INSERT INTO sockets (name) VALUES
  ('LGA 1150'),
  ('LGA 1151'),
  ('LGA 1155'),
  ('LGA 1156'),
  ('LGA 1366'),
  ('LGA 2011'),
  ('LGA 2066'),
  ('FM1'),
  ('FM2'),
  ('FM2+'),
  ('AM2'),
  ('AM2+'),
  ('AM3'),
  ('AM3+'),
  ('AM4');

# --- !Downs

TRUNCATE form_factors, sockets CASCADE;
