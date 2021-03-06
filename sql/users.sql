-- Jermaine Henry
-- September 13 2021
-- WEBD3201
CREATE EXTENSION IF NOT EXISTS pgcrypto;

DROP SEQUENCE IF EXISTS users_id_seq1 cascade;
CREATE SEQUENCE users_id_seq1 START 1000;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
		id INT PRIMARY KEY DEFAULT nextval('users_id_seq1'),
		EmailAddress VARCHAR(255) unique,
		FirstName varchar(120),
		LastName varchar(126),
		Password varchar(255) not null,
		CreatedTime TIMESTAMP,
		LastTime TIMESTAMP,
		PhoneExtension char(10),
		TYPE VARCHAR(2)


);

INSERT INTO users (EmailAddress,  FirstName, LastName, Password, CreatedTime, LastTime,  PhoneExtension, type) VALUES (
'jdoo@dcmail.ca','John', 'Doe', crypt('some_password',gen_salt('bf')), --NOTE: bf stand for blowfish
 '2021-01-12 12:32:45','2021-09-22 11:11:11', '4163492346','a');

INSERT INTO users (EmailAddress,  FirstName, LastName, Password, CreatedTime, LastTime,  PhoneExtension, type) VALUES (
'mScot@dcmail.ca', 'Micheal', 'Scot', crypt('theoffice',gen_salt('bf')), --NOTE: bf stand for blowfish
 '2021-12-12 12:32:45','2021-08-22 15:43:11', '4164580259','a'
);

INSERT INTO users (EmailAddress,  FirstName, LastName, Password, CreatedTime, LastTime,  PhoneExtension, type) VALUES (
'DSchrute@dcmail.ca', 'Dwight', 'Schrute', crypt('bearsbeatsgrills',gen_salt('bf')), --NOTE: bf stand for blowfish
 '2021-01-30 12:32:45','2021-06-17 11:11:11', '9052199286','a'
);

-- Sales People
INSERT INTO users (EmailAddress,  FirstName, LastName, Password, CreatedTime, LastTime,  PhoneExtension, type) VALUES (
'JimH@dcmail.ca', 'Jim', 'Halpert', crypt('pamb',gen_salt('bf')), --NOTE: bf stand for blowfish
 '2021-01-30 12:32:45','2021-06-17 11:11:11', '9052199286','s'
);

INSERT INTO users (EmailAddress,  FirstName, LastName, Password, CreatedTime, LastTime,  PhoneExtension, type) VALUES (
'StarkIndi@dcmail.ca', 'Tony', 'Stark', crypt('IRONMAN',gen_salt('bf')), --NOTE: bf stand for blowfish
 '2021-01-30 12:32:45','2021-06-17 01:11:11', '9054125415','s'
);

INSERT INTO users (EmailAddress,  FirstName, LastName, Password, CreatedTime, LastTime,  PhoneExtension, type) VALUES (
'OliveD@dcmail.ca', 'Donald', 'Oliver', crypt('twist',gen_salt('bf')), --NOTE: bf stand for blowfish
 '2021-01-30 12:32:45','2021-11-17 12:11:11', '9058963675','s'
);


select * from "user";
