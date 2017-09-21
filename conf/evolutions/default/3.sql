# --- !Ups

CREATE TABLE chassis_form_factor (
  id SERIAL PRIMARY KEY,

  chassis_id INT NOT NULL REFERENCES chassis (id) ON DELETE CASCADE,
  form_factor_id INT NOT NULL REFERENCES form_factors (id) ON DELETE RESTRICT
);

CREATE TABLE cooling_solution_form_factor (
  id SERIAL PRIMARY KEY,

  cooling_solution_id INT NOT NULL REFERENCES cooling_solutions (id) ON DELETE CASCADE,
  socket_id INT NOT NULL REFERENCES sockets (id) ON DELETE RESTRICT
);

# --- !Downs

DROP TABLE chassis_form_factor, cooling_solution_form_factor;
