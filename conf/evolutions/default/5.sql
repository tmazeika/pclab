# --- !Ups

INSERT INTO chassis (
  brand, name, cost, power_usage, weight, max_cooling_fan_height,
  max_graphics_card_length_blocked, max_graphics_card_length_full,
  audio_headers, fan_headers, usb2_headers, usb3_headers, uses_sata_power,
  max_power_supply_length, bays_2p5, bays_3p5, bays_adaptable, cage_bays_2p5,
  cage_bays_3p5, cage_bays_adaptable
) VALUES (
  'Phanteks', 'Enthoo EVOLV Glass', 19000, 0, 10200, 194, 300, 420, 1, 3, 0, 1,
  false, 318, 2, 0, 8, 0, 0, 5
), (
  'Fractal Design', 'Define R5', 11000, 0, 10300, 180, 310, 440, 1, 2, 1, 1,
  false, 300, 2, 0, 8, 0, 0, 5
);

INSERT INTO cooling_solutions (
  brand, name, cost, power_usage, weight, tdp, height, max_memory_stick_height
) VALUES (
  'Cooler Master', 'Hyper 212 EVO', 3000, 3, 580, 180, 159, 37
);

INSERT INTO graphics_cards (
  brand, name, cost, power_usage, weight, family, has_displayport_out,
  has_dvi_out, has_hdmi_out, has_vga_out, supports_sli, length
) VALUES (
  'MSI', 'GTX 1080 ARMOR', 54400, 180, 907, 'NVIDIA', true, true, true, false,
  true, 280
);

INSERT INTO memory_sticks (
  brand, name, cost, power_usage, weight, capacity, gen, pins, height
) VALUES (
  'Crucial', 'Ballistix Sport LT', 6800, 10, 145, 8000, 4, 288, 12
), (
  'Crucial', 'Vengeance LPX', 8000, 10, 82, 8, 4, 288, 10
);

INSERT INTO motherboards (
  brand, name, cost, power_usage, weight, form_factor_id, has_displayport_out,
  has_dvi_out, has_hdmi_out, has_vga_out, pcie3_slots, supports_sli,
  audio_headers, fan_headers, usb2_headers, usb3_headers, max_memory_capacity,
  memory_gen, memory_pins, memory_slots, cpu_power_pins, main_power_pins,
  socket_id, sata_slots
) VALUES (
  'ASUS', 'Z170-A', 14000, 0, 998,
  (SELECT id FROM form_factors WHERE name = 'ATX'), true, true, true, true, 3,
  true, 1, 4, 2, 2, 64, 4, 288, 4, 8, 24,
  (SELECT id FROM sockets WHERE name = 'LGA 1151'), 4
), (
  'MSI', 'B350 TOMAHAWK', 10000, 0, 1270,
  (SELECT id FROM form_factors WHERE name = 'ATX'), false, true, true, true, 2,
  false, 1, 4, 2, 2, 64, 4, 288, 4, 8, 24,
  (SELECT id FROM sockets WHERE name = 'AM4'), 4
);

INSERT INTO power_supplies (
  brand, name, cost, power_usage, weight, cpu_pins, is_modular, main_pins, power_out,
  length
) VALUES (
  'Corsair', 'HX750i', 16000, 0, 3227, 8, true, 24, 750, 180
);

INSERT INTO processors (
  brand, name, model, cost, power_usage, weight, socket_id, has_apu
) VALUES (
  'Intel', 'Core i7', '7700K', 33500, 91, 95,
  (SELECT id FROM sockets WHERE name = 'LGA 1151'), true
), (
  'Intel', 'Core i5', '6500', 20000, 35, 295,
  (SELECT id FROM sockets WHERE name = 'LGA 1151'), true
), (
  'Intel', 'Core i3', '6100', 12000, 51, 272,
  (SELECT id FROM sockets WHERE name = 'LGA 1151'), true
), (
  'AMD', 'Ryzen 7', '1800X', 43000, 95, 119,
  (SELECT id FROM sockets WHERE name = 'AM4'), true
);

INSERT INTO storage_devices (
  brand, name, cost, power_usage, weight, capacity, is_full_width
) VALUES (
  'Samsung', '850 EVO', 15000, 2, 54, 1000, false
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
