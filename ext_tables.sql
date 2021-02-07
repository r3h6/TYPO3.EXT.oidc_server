CREATE TABLE fe_users (

	tx_oidcserver_nickname varchar(255) DEFAULT '' NOT NULL,
	tx_oidcserver_gender varchar(255) DEFAULT '' NOT NULL,
	tx_oidcserver_birthdate date DEFAULT NULL,
	tx_oidcserver_locale varchar(255) DEFAULT '' NOT NULL,
	tx_oidcserver_zoneinfo varchar(255) DEFAULT '' NOT NULL,

);
