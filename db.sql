CREATE TABLE `language` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(2) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`code`),
  UNIQUE KEY `title` (`title`),
  INDEX (`is_group`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `language` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `language`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `geo_macroregion_geo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  INDEX (`is_group`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `geo_macroregion_geo` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `geo_macroregion_geo`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `geo_macroregion_com` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  INDEX (`is_group`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `geo_macroregion_com` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `geo_macroregion_com`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `geo_country` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `iso3` char(3) NOT NULL DEFAULT '',
  `iso2` char(2) NOT NULL DEFAULT '',
  `zip_name` varchar(255) NOT NULL DEFAULT '',
  `geo_macroregion_geo_id` int(10) unsigned,
  `geo_macroregion_com_id` int(10) unsigned,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  FOREIGN KEY (geo_macroregion_geo_id) REFERENCES geo_macroregion_geo(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (geo_macroregion_com_id) REFERENCES geo_macroregion_com(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX (`is_group`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `geo_country` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `geo_country`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `geo_region` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `geo_country_id` int(10) unsigned NOT NULL,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  FOREIGN KEY (geo_country_id) REFERENCES geo_country(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX (`is_group`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `geo_region` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `geo_region`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `geo_city` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `geo_country_id` int(10) unsigned NOT NULL,
  `geo_region_id` int(10) unsigned NOT NULL,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  FOREIGN KEY (geo_country_id) REFERENCES geo_country(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (geo_region_id) REFERENCES geo_region(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX (`is_group`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `geo_city` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `geo_city`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `geo_street_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `geo_country_id` int(10) unsigned NOT NULL,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  FOREIGN KEY (geo_country_id) REFERENCES geo_country(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX (`is_group`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `geo_street_type` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `geo_street_type`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `geo_street` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `geo_country_id` int(10) unsigned NOT NULL,
  `geo_region_id` int(10) unsigned NOT NULL,
  `geo_city_id` int(10) unsigned NOT NULL,
  `geo_street_type_id` int(10) unsigned NOT NULL,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  FOREIGN KEY (geo_country_id) REFERENCES geo_country(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (geo_region_id) REFERENCES geo_region(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (geo_city_id) REFERENCES geo_city(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (geo_street_type_id) REFERENCES geo_street_type(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX (`is_group`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `geo_street` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `geo_street`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `type` ENUM ('weight', 'volume', 'quantity', 'time') NOT NULL, /* весовой объемный колличественный временной */
  `base_id` int(10) unsigned, /* ключ родительской группы */
  `ratio_to_base` DECIMAL(24, 5) UNSIGNED NOT NULL,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  INDEX (`is_group`),
  INDEX (`type`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `units` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `units`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `units` ADD CONSTRAINT FOREIGN KEY (`base_id`) REFERENCES `units`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `currency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `ratio` DECIMAL(7) UNSIGNED NOT NULL,
  `rate` DECIMAL(21, 2) UNSIGNED NOT NULL,
  `rate_month` DECIMAL(21, 2) UNSIGNED NOT NULL,
  `iso3` char(3) NOT NULL DEFAULT '',
  `sign` char(1) NOT NULL DEFAULT '',
  `geo_country_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  FOREIGN KEY (geo_country_id) REFERENCES geo_country(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `currency_name` (
  `currency_id` int(10) unsigned NOT NULL,
  `language` char(2) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`currency_id`, `language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `currency_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `currency_id` int(10) unsigned NOT NULL,
  `ratio` DECIMAL(7) UNSIGNED NOT NULL,
  `rate` DECIMAL(21, 2) UNSIGNED NOT NULL,
  `rate_month` DECIMAL(21, 2) UNSIGNED NOT NULL,
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (currency_id) REFERENCES currency(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `contractor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `type` ENUM ('company', 'person', 'businessman') NOT NULL, /* ЮрЛицо ФизЛицо Предприниматель */
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  INDEX (`type`),
  INDEX (`is_group`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `contractor` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `contractor`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `contractor_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contractor_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (contractor_id) REFERENCES contractor(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `address_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `type` ENUM ('registry', 'logistic', 'other') NOT NULL, /* Регистрационный Логистический Прочий */
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  INDEX (`type`),
  INDEX (`is_group`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `address_type` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `address_type`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `contact_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `type` ENUM ('url', 'e-mail', 'phone', 'chat', 'fax') NOT NULL,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  INDEX (`type`),
  INDEX (`is_group`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `contact_type` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `contact_type`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `contractor_contact_person` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) NOT NULL DEFAULT '',
  `middle_name` varchar(255) NOT NULL DEFAULT '',
  `prefix` ENUM ('Ing.', 'Mudr.', 'Mgr.', 'Doc.', 'Phd.', 'Bc.'),
  `birthday` DATETIME,
  `gender` ENUM ('male', 'female'),
  `position` varchar(255) NOT NULL DEFAULT '',
  `nation` varchar(255) NOT NULL DEFAULT '',
  `language_id` int(10) unsigned,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  FOREIGN KEY (language_id) REFERENCES language(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX (`is_group`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `contractor_contact_person` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `contractor_contact_person`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `contractor_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `geo_country_id` int(10) unsigned NOT NULL,
  `geo_region_id` int(10) unsigned NOT NULL,
  `geo_city_id` int(10) unsigned NOT NULL,
  `geo_street_id` int(10) unsigned NOT NULL,
  `address` varchar(255) NOT NULL DEFAULT '',
  `postal_code` varchar(255) NOT NULL DEFAULT '',
  `address_type_id` int(10) unsigned,
  `contractor_contact_person_id` int(10) unsigned,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `group_id` int(10) unsigned, /* ключ родительской группы */
  `is_group` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  FOREIGN KEY (geo_country_id) REFERENCES geo_country(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (geo_region_id) REFERENCES geo_region(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (geo_city_id) REFERENCES geo_city(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (geo_street_id) REFERENCES geo_street(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (contractor_contact_person_id) REFERENCES contractor_contact_person(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX (`is_group`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `contractor_address` ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `contractor_address`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `contractor_id` int(10) unsigned NOT NULL,
  `geo_country_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  FOREIGN KEY (contractor_id) REFERENCES contractor(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (geo_country_id) REFERENCES geo_country(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `company_structure_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  INDEX (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2ooBv0kl6bxNrh0jIF77UZVjv8Uw0dKR', '$2y$13$dcRxDUdsew6y3oD98J0nOeM/IJbsA5VbmWRCHZyCztc5LkpN5edii', NULL, 'admin@test.com', 10, 1504560806, 1504560806);

