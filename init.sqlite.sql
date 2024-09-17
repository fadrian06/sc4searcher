CREATE TABLE IF NOT EXISTS users (
  username VARCHAR(255) PRIMARY KEY,
  password VARCHAR(255) UNIQUE NOT NULL CHECK (LENGTH(password) >= 8)
);

CREATE TABLE IF NOT EXISTS categories (
  name VARCHAR(255) PRIMARY KEY,
  parent_category VARCHAR(255),

  FOREIGN KEY (parent_category) REFERENCES categories (name) ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS modders (
  name VARCHAR(255) NOT NULL PRIMARY KEY,
  profile_link
    VARCHAR(255)
    UNIQUE
    NOT NULL
    CHECK (profile_link LIKE 'https://community.simtropolis.com/profile/%'),
  profile_image_link VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS groups (
  name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE IF NOT EXISTS plugins (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR(255) NOT NULL,
  link VARCHAR(255) UNIQUE NOT NULL CHECK (link LIKE 'http%'),
  version VARCHAR(255) NOT NULL,
  submitted DATE NOT NULL,
  updated DATE NOT NULL,
  description TEXT,
  installation TEXT NOT NULL,
  sc4pac_id VARCHAR(255) UNIQUE CHECK (sc4pac_id LIKE '%:%'),
  desinstallation TEXT NOT NULL,
  modder VARCHAR(255) NOT NULL,
  category VARCHAR(255) NOT NULL,
  group_name VARCHAR(255),

  UNIQUE (name, modder),
  FOREIGN KEY (modder) REFERENCES modders (name),
  FOREIGN KEY (category) REFERENCES categories (name),
  FOREIGN KEY (group_name) REFERENCES groups (name)
);

CREATE TABLE IF NOT EXISTS dependencies (
  dependent_id INTEGER NOT NULL,
  dependency_id INTEGER NOT NULL,

  CHECK (dependent_id != dependency_id),
  FOREIGN KEY (dependent_id) REFERENCES plugins (id),
  FOREIGN KEY (dependency_id) REFERENCES plugins (id)
);

DELETE FROM modders;
INSERT INTO modders (name, profile_link, profile_image_link)
VALUES ('memo', 'https://community.simtropolis.com/profile/95442-memo/', 'https://www.simtropolis.com/objects/profiles/profile/photo-95442.gif');

DELETE FROM categories;
INSERT INTO categories (name, parent_category)
VALUES ('Bug Fixes', null);

DELETE FROM groups;
INSERT INTO groups (name)
VALUES ('BSC'), ('HKABT'), ('LBT'), ('SFBT');

DELETE FROM plugins;
INSERT INTO plugins (
  id, name, link, version, submitted, updated, description,
  installation, sc4pac_id, desinstallation, modder, category, group_name
) VALUES (1, 'Region Thumbnail Fix DLL', 'https://community.simtropolis.com/files/file/36396-region-thumbnail-fix-dll/', '1.0.0', '2024-08-07', '2024-08-07', null, '', 'memo:region-thumbnail-fix-dll', '', 'memo', 'Bug Fixes', null);
