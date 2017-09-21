# --- !Ups

-- chassis

INSERT INTO components (id, brand, cost, model, name, power_cost, weight) VALUES
    (1, 'Phanteks', 1900, 'Tempered Glass ATX', 'Enthoo EVOLV', 0, 10200),
    (2, 'Fractal Design', 11000, NULL, 'Define R5', 0, 10300);

INSERT INTO chassis (
  component_id, adapatable_bays, adapatable_cage_bays, audio_headers,
  fan_headers, full_bays, full_cage_bays, max_blocked_graphics_card_length,
  max_cooling_fan_height, max_full_graphics_card_length,
  max_power_supply_length, small_bays, small_cage_bays, usb2_headers,
  usb3_headers, uses_sata_power
) VALUES (
    1, 8, 5, 1, 3, 0, 0, 300, 194, 420, 318, 2, 0, 0, 1, FALSE
), (
    2, 8, 5, 1, 2, 0, 0, 310, 180, 440, 300, 2, 0, 1, 1, FALSE
);

-- cooling_solutions

INSERT INTO components (id, brand, cost, model, name, power_cost, weight) VALUES
    (3, 'Cooler Master', 3000, NULL, 'Hyper 212 EVO', 3, 580);

INSERT INTO cooling_solutions (
  component_id, height, max_memory_stick_height, tdp
) VALUES (
    3, 159, 37, 180
);

-- graphics_cards

INSERT INTO components (id, brand, cost, model, name, power_cost, weight) VALUES
    (4, 'MSI', 54400, NULL, 'GTX 1080 ARMOR', 180, 907);

INSERT INTO graphics_cards (
  component_id, family, has_displayport, has_dvi, has_hdmi, has_vga, length,
  supports_sli
) VALUES (
    4, 'NVIDIA', TRUE, TRUE, TRUE, FALSE, 280, TRUE
);

-- memory_sticks

INSERT INTO components (id, brand, cost, model, name, power_cost, weight) VALUES
    (5, 'Crucial', 6800, NULL, 'Ballistix Sport LT', 10, 145),
    (6, 'Crucial', 8000, NULL, 'Vengeance LPX', 10, 82);

INSERT INTO memory_sticks (
  component_id, capacity, generation, height, pins
) VALUES (
    5, 8000, 4, 12, 288
), (
    6, 8000, 4, 10, 288
);

-- motherboards

INSERT INTO components (id, brand, cost, model, name, power_cost, weight) VALUES
    (7, 'ASUS', 14000, NULL, 'Z170-A', 0, 998),
    (8, 'MSI', 10000, NULL, 'B350 TOMAHAWK', 0, 1270);

INSERT INTO motherboards (
  component_id, audio_headers, cpu_power_4pins, cpu_power_8pins, fan_headers,
  form_factor_id, has_displayport, has_dvi, has_hdmi, has_vga, main_power_pins,
  max_memory_capacity, memory_generation, memory_pins, memory_slots,
  pcie3_slots, sata_slots, socket_id, supports_sli, usb2_headers, usb3_headers
) VALUES (
    7, 1, 0, 1, 4, (SELECT id FROM form_factors WHERE name = 'ATX'), TRUE, TRUE,
    TRUE, TRUE, 24, 64000, 4, 288, 4, 3, 4,
    (SELECT id FROM sockets WHERE name = 'LGA 1151'), TRUE, 2, 2
), (
    8, 1, 0, 1, 4, (SELECT id FROM form_factors WHERE name = 'ATX'), FALSE, TRUE,
    TRUE, TRUE, 24, 64000, 4, 288, 4, 2, 4,
    (SELECT id FROM sockets WHERE name = 'AM4'), FALSE, 2, 2
);

-- power_supplies

INSERT INTO components (id, brand, cost, model, name, power_cost, weight) VALUES
    (9, 'Corsair', 16000, NULL, 'HX750i', 0, 3227);

INSERT INTO power_supplies (
  component_id, cpu_4pins, cpu_8pins, cpu_adaptable, is_modular, length,
  main_20pins, main_24pins, main_adaptable, power_output
) VALUES (
    9, 0, 0, 2, TRUE, 180, 0, 0, 1, 750
);

-- processors

INSERT INTO components (id, brand, cost, model, name, power_cost, weight) VALUES
    (10, 'Intel', 33500, '7700K', 'Core i7', 91, 95),
    (11, 'Intel', 20000, '6500', 'Core i5', 35, 295),
    (12, 'Intel', 12000, '6100', 'Core i3', 51, 272),
    (13, 'AMD', 43000, '1800X', 'Ryzen 7', 95, 119);

INSERT INTO processors (component_id, has_apu, socket_id) VALUES
  (10, TRUE, (SELECT id FROM sockets WHERE name = 'LGA 1151')),
  (11, TRUE, (SELECT id FROM sockets WHERE name = 'LGA 1151')),
  (12, TRUE, (SELECT id FROM sockets WHERE name = 'LGA 1151')),
  (13, TRUE, (SELECT id FROM sockets WHERE name = 'AM4'));

-- storage_devices

INSERT INTO components (id, brand, cost, model, name, power_cost, weight) VALUES
  (14, 'Samsung', 15000, NULL, '850 EVO', 2, 54);

INSERT INTO storage_devices (component_id, capacity, is_full_width) VALUES (
    14, 1000000, FALSE
);

# --- !Downs

TRUNCATE
  chassis,
  cooling_solutions,
  graphics_cards,
  memory_sticks,
  motherboards,
  power_supplies,
  processors,
  storage_devices
CASCADE;
