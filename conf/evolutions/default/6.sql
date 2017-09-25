# --- !Ups

INSERT INTO chassis_form_factor (chassis_id, form_factor_id) VALUES
(
  (SELECT chassis.id FROM chassis JOIN components ON component_id = components.id WHERE name = 'Enthoo EVOLV'),
  (SELECT id FROM form_factors WHERE name = 'ATX')
), (
  (SELECT chassis.id FROM chassis JOIN components ON component_id = components.id WHERE name = 'Enthoo EVOLV'),
  (SELECT id FROM form_factors WHERE name = 'E-ATX')
), (
  (SELECT chassis.id FROM chassis JOIN components ON component_id = components.id WHERE name = 'Enthoo EVOLV'),
  (SELECT id FROM form_factors WHERE name = 'Micro-ATX')
), (
  (SELECT chassis.id FROM chassis JOIN components ON component_id = components.id WHERE name = 'Enthoo EVOLV'),
  (SELECT id FROM form_factors WHERE name = 'Mini-ITX')
), (
  (SELECT chassis.id FROM chassis JOIN components ON component_id = components.id WHERE name = 'Define R5'),
  (SELECT id FROM form_factors WHERE name = 'ATX')
), (
  (SELECT chassis.id FROM chassis JOIN components ON component_id = components.id WHERE name = 'Define R5'),
  (SELECT id FROM form_factors WHERE name = 'Micro-ATX')
), (
  (SELECT chassis.id FROM chassis JOIN components ON component_id = components.id WHERE name = 'Define R5'),
  (SELECT id FROM form_factors WHERE name = 'Mini-ITX')
);

INSERT INTO cooling_solution_socket (cooling_solution_id, socket_id) VALUES
(
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 1150')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 1151')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 1155')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 1156')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 1366')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 2011')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 2066')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'FM1')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'FM2')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'FM2+')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'AM2')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id  WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'AM2+')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'AM3')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'AM3+')
), (
  (SELECT cooling_solutions.id FROM cooling_solutions JOIN components ON component_id = components.id WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'AM4')
);

# --- !Downs

TRUNCATE
  chassis_form_factor,
  cooling_solution_socket
CASCADE;
