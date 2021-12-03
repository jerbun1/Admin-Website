-- Jermaine Henry 
-- Oct 30 2021
-- Sales People Database
CREATE EXTENSION IF NOT EXISTS pgcrypto;

DROP SEQUENCE IF EXISTS Calls_id_seq1 cascade;
CREATE SEQUENCE Calls_id_seq1 START 1000;

DROP TABLE IF EXISTS Calls;
CREATE TABLE Calls (
		Call_id INT PRIMARY KEY DEFAULT nextval('calls_id_seq1'),
		FirstName varchar(120),
		LastName varchar(126),
        CallTime TIMESTAMP,
		client_id INT references clients(Client_id)
);