# --- !Ups

CREATE TABLE IF NOT EXISTS components (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,

  -- market
  is_available_immediately BOOLEAN NOT NULL,
  cost INT NOT NULL, -- pennies

  -- power
  power_usage INT NOT NULL, -- watts

  -- physical
  weight INT NOT NULL -- grams
);

CREATE TABLE IF NOT EXISTS memory (
  capacity INT NOT NULL, -- megabytes
  gen SMALLINT NOT NULL,
  pins SMALLINT NOT NULL,

  -- physical
  height SMALLINT NOT NULL -- millimeters
) INHERITS (components);

CREATE TABLE IF NOT EXISTS motherboards (
  form_factor_id INT NOT NULL REFERENCES form_factors (id) ON DELETE RESTRICT,

  -- graphics
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

  -- memory
  max_memory_capacity INT NOT NULL, -- megabytes
  memory_gen SMALLINT NOT NULL,
  memory_pins SMALLINT NOT NULL,
  memory_slots SMALLINT NOT NULL,
  
  -- power
  cpu_power_pins SMALLINT NOT NULL CHECK (cpu_power_pins IN (0, 4, 8)),
  main_power_pins SMALLINT NOT NULL CHECK (main_power_pins IN (20, 24)),

  -- processor
  socket_id INT NOT NULL REFERENCES sockets (id) ON DELETE RESTRICT,

  -- storage
  sata_slots SMALLINT NOT NULL
) INHERITS (components);

CREATE TABLE IF NOT EXISTS processors (
  socket_id INT NOT NULL REFERENCES sockets (id) ON DELETE RESTRICT,

  -- cooling
  tdp SMALLINT NOT NULL, -- watts

  -- graphics
  has_apu BOOLEAN NOT NULL
) INHERITS (components);

CREATE TABLE IF NOT EXISTS storage_devices (
  capacity INT NOT NULL, -- megabytes

  -- physical
  is_full_width BOOLEAN NOT NULL
) INHERITS (components);

# --- !Downs

DROP TABLE IF EXISTS components;
DROP TABLE IF EXISTS memory;
DROP TABLE IF EXISTS motherboards;
DROP TABLE IF EXISTS processors;
DROP TABLE IF EXISTS storage_devices;
