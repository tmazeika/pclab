# --- !Ups

CREATE TABLE components (
  id SERIAL PRIMARY KEY,

  brand VARCHAR(255) NOT NULL,
  cost INT NOT NULL, -- pennies
  is_available_immediately BOOLEAN NOT NULL DEFAULT TRUE,
  model VARCHAR(255),
  name VARCHAR(255) NOT NULL,
  power_cost SMALLINT NOT NULL, -- watts
  preview_img_hash VARCHAR(40) NOT NULL, -- sha1
  weight INT NOT NULL -- grams
);

CREATE TABLE chassis (
  id SERIAL PRIMARY KEY,
  component_id INT NOT NULL UNIQUE REFERENCES components (id) ON DELETE CASCADE,

  adaptable_bays SMALLINT NOT NULL,
  adaptable_cage_bays SMALLINT NOT NULL,
  audio_headers SMALLINT NOT NULL,
  fan_headers SMALLINT NOT NULL,
  full_bays SMALLINT NOT NULL,
  full_cage_bays SMALLINT NOT NULL,
  max_blocked_graphics_card_length SMALLINT NOT NULL, -- millimeters
  max_cooling_fan_height SMALLINT NOT NULL, -- millimeters
  max_full_graphics_card_length SMALLINT NOT NULL, -- millimeters
  max_power_supply_length SMALLINT NOT NULL, -- millimeters
  small_bays SMALLINT NOT NULL,
  small_cage_bays SMALLINT NOT NULL,
  usb2_headers SMALLINT NOT NULL,
  usb3_headers SMALLINT NOT NULL,
  uses_sata_power BOOLEAN NOT NULL
);

CREATE TABLE cooling_solutions (
  id SERIAL PRIMARY KEY,
  component_id INT NOT NULL UNIQUE REFERENCES components (id) ON DELETE CASCADE,

  height SMALLINT NOT NULL, -- millimeters
  max_memory_stick_height SMALLINT NOT NULL, -- millimeters
  tdp SMALLINT NOT NULL -- watts
);

CREATE TABLE graphics_cards (
  id SERIAL PRIMARY KEY,
  component_id INT NOT NULL UNIQUE REFERENCES components (id) ON DELETE CASCADE,

  family VARCHAR(255) NOT NULL,
  has_displayport BOOLEAN NOT NULL,
  has_dvi BOOLEAN NOT NULL,
  has_hdmi BOOLEAN NOT NULL,
  has_vga BOOLEAN NOT NULL,
  length SMALLINT NOT NULL, -- millimeters
  supports_sli BOOLEAN NOT NULL
);

CREATE TABLE memory_sticks (
  id SERIAL PRIMARY KEY,
  component_id INT NOT NULL UNIQUE REFERENCES components (id) ON DELETE CASCADE,

  capacity INT NOT NULL, -- megabytes
  generation SMALLINT NOT NULL,
  height SMALLINT NOT NULL, -- millimeters
  pins SMALLINT NOT NULL
);

CREATE TABLE motherboards (
  id SERIAL PRIMARY KEY,
  component_id INT NOT NULL UNIQUE REFERENCES components (id) ON DELETE CASCADE,

  audio_headers SMALLINT NOT NULL,
  cpu_power_4pins SMALLINT NOT NULL,
  cpu_power_8pins SMALLINT NOT NULL,
  fan_headers SMALLINT NOT NULL,
  form_factor_id INT NOT NULL REFERENCES form_factors (id) ON DELETE RESTRICT,
  has_displayport BOOLEAN NOT NULL,
  has_dvi BOOLEAN NOT NULL,
  has_hdmi BOOLEAN NOT NULL,
  has_vga BOOLEAN NOT NULL,
  main_power_pins SMALLINT NOT NULL CHECK (main_power_pins IN (20, 24)),
  max_memory_capacity INT NOT NULL, -- megabytes
  memory_generation SMALLINT NOT NULL,
  memory_pins SMALLINT NOT NULL,
  memory_slots SMALLINT NOT NULL,
  pcie3_slots SMALLINT NOT NULL,
  sata_slots SMALLINT NOT NULL,
  socket_id INT NOT NULL REFERENCES sockets (id) ON DELETE RESTRICT,
  supports_sli BOOLEAN NOT NULL,
  usb2_headers SMALLINT NOT NULL,
  usb3_headers SMALLINT NOT NULL
);

CREATE TABLE power_supplies (
  id SERIAL PRIMARY KEY,
  component_id INT NOT NULL UNIQUE REFERENCES components (id) ON DELETE CASCADE,

  cpu_4pins SMALLINT NOT NULL,
  cpu_8pins SMALLINT NOT NULL,
  cpu_adaptable SMALLINT NOT NULL,
  is_modular BOOLEAN NOT NULL,
  length SMALLINT NOT NULL, -- millimeters
  main_20pins SMALLINT NOT NULL,
  main_24pins SMALLINT NOT NULL,
  main_adaptable SMALLINT NOT NULL,
  power_output SMALLINT NOT NULL -- watts
);

CREATE TABLE processors (
  id SERIAL PRIMARY KEY,
  component_id INT NOT NULL UNIQUE REFERENCES components (id) ON DELETE CASCADE,

  has_gpu BOOLEAN NOT NULL,
  socket_id INT NOT NULL REFERENCES sockets (id) ON DELETE RESTRICT
);

CREATE TABLE storage_devices (
  id SERIAL PRIMARY KEY,
  component_id INT NOT NULL UNIQUE REFERENCES components (id) ON DELETE CASCADE,

  capacity INT NOT NULL, -- megabytes
  is_full_width BOOLEAN NOT NULL
);

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
