# --- !Ups

INSERT INTO chassis_form_factor (chassis_id, form_factor_id) VALUES
(
  (SELECT id FROM chassis WHERE name = 'Enthoo EVOLV Glass'),
  (SELECT id FROM form_factors WHERE name = 'ATX')
), (
  (SELECT id FROM chassis WHERE name = 'Enthoo EVOLV Glass'),
  (SELECT id FROM form_factors WHERE name = 'E-ATX')
), (
  (SELECT id FROM chassis WHERE name = 'Enthoo EVOLV Glass'),
  (SELECT id FROM form_factors WHERE name = 'Micro-ATX')
), (
  (SELECT id FROM chassis WHERE name = 'Enthoo EVOLV Glass'),
  (SELECT id FROM form_factors WHERE name = 'Mini-ITX')
), (
  (SELECT id FROM chassis WHERE name = 'Define R5'),
  (SELECT id FROM form_factors WHERE name = 'ATX')
), (
  (SELECT id FROM chassis WHERE name = 'Define R5'),
  (SELECT id FROM form_factors WHERE name = 'Micro-ATX')
), (
  (SELECT id FROM chassis WHERE name = 'Define R5'),
  (SELECT id FROM form_factors WHERE name = 'Mini-ITX')
);

INSERT INTO cooling_solution_form_factor (cooling_solution_id, socket_id) VALUES
(
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 1150')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 1151')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 1155')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 1156')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 1366')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 2011')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'LGA 2066')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'FM1')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'FM2')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'FM2+')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'AM2')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'AM2+')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'AM3')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'AM3+')
), (
  (SELECT id FROM cooling_solutions WHERE name = 'Hyper 212 EVO'),
  (SELECT id FROM sockets WHERE name = 'AM4')
);

# --- !Downs

TRUNCATE
  chassis_form_factor,
  cooling_solution_form_factor
CASCADE;
