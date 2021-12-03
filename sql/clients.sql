-- Jermaine Henry 
-- Nov 22 2021
-- Sales People Database
CREATE EXTENSION IF NOT EXISTS pgcrypto;

DROP SEQUENCE IF EXISTS Clients_id_seq1 cascade;
CREATE SEQUENCE Clients_id_seq1 START 1000;

DROP TABLE IF EXISTS Clients;
CREATE TABLE Clients (
		Client_id INT PRIMARY KEY DEFAULT nextval('client_id_seq1'),
		EmailAddress VARCHAR(255) unique,
		FirstName varchar(120),
		LastName varchar(126),
		PhoneNumber char(10),
		users_id INT references users(id),
		Logo BLOB NOT NULL
);