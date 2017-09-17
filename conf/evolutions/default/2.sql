# --- !Ups

CREATE TABLE components (
  id SERIAL PRIMARY KEY,
  brand VARCHAR(255) NOT NULL,
  name VARCHAR(255) NOT NULL,
  model VARCHAR(255),

  -- market
  is_available_immediately BOOLEAN NOT NULL DEFAULT TRUE,
  cost INT NOT NULL, -- pennies

  -- power_supplies
  power_usage SMALLINT NOT NULL, -- watts

  -- physical
  weight INT NOT NULL -- grams
);

CREATE TABLE chassis (
  id SERIAL PRIMARY KEY,

  -- cooling_solutions
  max_cooling_fan_height SMALLINT NOT NULL, -- millimeters

  -- graphics_cards
  max_graphics_card_length_blocked SMALLINT NOT NULL, -- millimeters
  max_graphics_card_length_full SMALLINT NOT NULL, -- millimeters

  -- motherboards
  audio_headers SMALLINT NOT NULL,
  fan_headers SMALLINT NOT NULL,
  usb2_headers SMALLINT NOT NULL,
  usb3_headers SMALLINT NOT NULL,

  -- power_supplies
  uses_sata_power BOOLEAN NOT NULL,
  max_power_supply_length SMALLINT NOT NULL, -- millimeters

  -- storage_devices
  bays_2p5 SMALLINT NOT NULL,
  bays_3p5 SMALLINT NOT NULL,
  bays_adaptable SMALLINT NOT NULL,
  cage_bays_2p5 SMALLINT NOT NULL,
  cage_bays_3p5 SMALLINT NOT NULL,
  cage_bays_adaptable SMALLINT NOT NULL
) INHERITS (components);

CREATE TABLE cooling_solutions (
  id SERIAL PRIMARY KEY,

  tdp SMALLINT NOT NULL, -- watts

  -- physical
  height SMALLINT NOT NULL, -- millimeters
  max_memory_stick_height SMALLINT NOT NULL -- millimeters
) INHERITS (components);

CREATE TABLE graphics_cards (
  id SERIAL PRIMARY KEY,

  family VARCHAR(255) NOT NULL,

  has_displayport_out BOOLEAN NOT NULL,
  has_dvi_out BOOLEAN NOT NULL,
  has_hdmi_out BOOLEAN NOT NULL,
  has_vga_out BOOLEAN NOT NULL,
  supports_sli BOOLEAN NOT NULL,

  -- physical
  length SMALLINT NOT NULL -- millimeters
) INHERITS (components);

CREATE TABLE memory_sticks (
  id SERIAL PRIMARY KEY,

  capacity INT NOT NULL, -- megabytes
  gen SMALLINT NOT NULL,
  pins SMALLINT NOT NULL,

  -- physical
  height SMALLINT NOT NULL -- millimeters
) INHERITS (components);

CREATE TABLE motherboards (
  id SERIAL PRIMARY KEY,

  form_factor_id INT NOT NULL REFERENCES form_factors (id) ON DELETE RESTRICT,

  -- graphics_cards
  has_displayport_out BOOLEAN NOT NULL,
  has_dvi_out BOOLEAN NOT NULL,
  has_hdmi_out BOOLEAN NOT NULL,
  has_vga_out BOOLEAN NOT NULL,
  pcie3_slots SMALLINT NOT NULL,
  supports_sli BOOLEAN NOT NULL,

  -- headers
  audio_headers SMALLINT NOT NULL,
  fan_headers SMALLINT NOT NULL,
  usb2_headers SMALLINT NOT NULL,
  usb3_headers SMALLINT NOT NULL,

  -- memory_sticks
  max_memory_capacity INT NOT NULL, -- megabytes
  memory_gen SMALLINT NOT NULL,
  memory_pins SMALLINT NOT NULL,
  memory_slots SMALLINT NOT NULL,

  -- power_supplies
  cpu_power_pins SMALLINT NOT NULL CHECK (cpu_power_pins IN (0, 4, 8)),
  main_power_pins SMALLINT NOT NULL CHECK (main_power_pins IN (20, 24)),

  -- processors
  socket_id INT NOT NULL REFERENCES sockets (id) ON DELETE RESTRICT,

  -- storage_devices
  sata_slots SMALLINT NOT NULL
) INHERITS (components);

CREATE TABLE power_supplies (
  id SERIAL PRIMARY KEY,

  cpu_pins SMALLINT NOT NULL CHECK (cpu_pins IN (0, 4, 8)),
  is_modular BOOLEAN NOT NULL,
  main_pins SMALLINT NOT NULL CHECK (main_pins IN (20, 24)),
  power_out SMALLINT NOT NULL, -- watts

  -- physical
  length SMALLINT NOT NULL -- millimeters
) INHERITS (components);

CREATE TABLE processors (
  id SERIAL PRIMARY KEY,

  socket_id INT NOT NULL REFERENCES sockets (id) ON DELETE RESTRICT,

  -- graphics_cards
  has_apu BOOLEAN NOT NULL
) INHERITS (components);

CREATE TABLE storage_devices (
  id SERIAL PRIMARY KEY,

  capacity INT NOT NULL, -- megabytes

  -- physical
  is_full_width BOOLEAN NOT NULL
) INHERITS (components);

# --- !Downs

DROP TABLE components,
  chassis,
  cooling_solutions,
  graphics_cards,
  memory_sticks,
  motherboards,
  power_supplies,
  processors,
  storage_devices;
