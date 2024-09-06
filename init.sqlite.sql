CREATE TABLE IF NOT EXISTS users (
  username VARCHAR(255) PRIMARY KEY,
  password VARCHAR(255) UNIQUE NOT NULL CHECK (LENGTH(password) >= 8)
);

CREATE TABLE IF NOT EXISTS categories (
  name VARCHAR(255) PRIMARY KEY,
  parent_category VARCHAR(255),

  FOREIGN KEY (parent_category) REFERENCES categories (name)
);

CREATE TABLE IF NOT EXISTS modders (
  name VARCHAR(255) PRIMARY KEY,
  link
    VARCHAR(255)
    UNIQUE
    NOT NULL
    CHECK (link LIKE 'https://community.simtropolis.com/profile/%')
);

CREATE TABLE IF NOT EXISTS groups (
  name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE IF NOT EXISTS plugins (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR(255) NOT NULL,
  link VARCHAR(255) UNIQUE NOT NULL CHECK (link LIKE 'http%'),
  modder VARCHAR(255) NOT NULL,
  category VARCHAR(255) NOT NULL,
  group_name VARCHAR(255),

  UNIQUE (name, modder),
  FOREIGN KEY (modder) REFERENCES modders (name),
  FOREIGN KEY (category) REFERENCES categories (name),
  FOREIGN KEY (group_name) REFERENCES groups (name)
);

CREATE TABLE IF NOT EXISTS dependencies (
  plugin_id INTEGER NOT NULL,
  dependency_id INTEGER NOT NULL,

  CHECK (plugin_id != dependency_id),
  FOREIGN KEY (plugin_id) REFERENCES plugins (id),
  FOREIGN KEY (dependency_id) REFERENCES plugins (id)
);
