 -- SQL DDL Intro aus der Übung
   
 -- Ihre Datenbank auswählen, ändern Sie den Namen entsprechend...
USE `dbwt_1`;

 -- Trigger löschen, falls er existiert
-- DROP TRIGGER IF EXISTS `Before_Mahlzeiten_Delete`;
-- DROP TRIGGER IF EXISTS `Before_Kategorien_Delete`;

 -- Tabelle löschen, falls Sie existiert
DROP TABLE IF EXISTS `befreundetMit`;
DROP TABLE IF EXISTS `gehörtZu`;
DROP TABLE IF EXISTS `enthältM`;
DROP TABLE IF EXISTS `enthältZ`;
DROP TABLE IF EXISTS `hatB`;
DROP TABLE IF EXISTS `brauchtD`;
DROP TABLE IF EXISTS `Kommentare`;
DROP TABLE IF EXISTS `Mitarbeiter`;
DROP TABLE IF EXISTS `Studenten`;
DROP TABLE IF EXISTS `Gäste`;
DROP TABLE IF EXISTS FH_Angehörige;
DROP TABLE IF EXISTS `Bestellungen`;
DROP TABLE IF EXISTS `Benutzer`;
DROP TABLE IF EXISTS `Preise`;
DROP TABLE IF EXISTS `Zutaten`;
DROP TABLE IF EXISTS `Mahlzeiten`;
DROP TABLE IF EXISTS `Kategorien`;
DROP TABLE IF EXISTS `Deklarationen`;
DROP TABLE IF EXISTS `Fachbereiche`;
-- DROP TABLE IF EXISTS `Bilder`;
DROP VIEW IF EXISTS Benutzertyp;
DROP VIEW IF EXISTS Mahlzeitentypen;
DROP PROCEDURE IF EXISTS korrekterPreis;


-- Empfohlen ist, zuerst die Attribute der Tabellen anzulegen und die Relationen 
-- anschließend vorzunehmen. dabei werden Sie erkennen, dass nicht jede Lösch-
-- reihenfolge (DROP) funktioniert.

CREATE TABLE Benutzer (
	Nummer INT UNSIGNED NOT NULL AUTO_INCREMENT,
	Email VARCHAR(255) NOT NULL, -- Backticks wegen Minus im namen
	Benutzername VARCHAR(255) NOT NULL, -- NOT NULL weil nicht optional
	Bild BLOB,
	AnlegeDatum DATE NOT NULL DEFAULT CURRENT_DATE,
	Vorname VARCHAR(255) NOT NULL,
	Nachname VARCHAR(255) NOT NULL,
	Aktiv BOOL NOT NULL,
	`Hash` CHAR(60) NOT NULL,
	LetzterLogin DATE DEFAULT NULL,
	Geburtsdatum DATE,
	`Alter` TINYINT UNSIGNED DEFAULT TIMESTAMPDIFF(YEAR, Geburtsdatum, CURRENT_DATE),
 	PRIMARY KEY (Nummer),
 	UNIQUE (Nummer),
 	UNIQUE (Email),
 	UNIQUE (Benutzername)
 	
);

CREATE TABLE befreundetMit (
	`Benutzer_Nummer` INT UNSIGNED,
	`Befreundet_Nummer` INT UNSIGNED,
	PRIMARY KEY (`Benutzer_Nummer`,`Befreundet_Nummer`),
	FOREIGN KEY (`Benutzer_Nummer`) REFERENCES Benutzer(Nummer),
	FOREIGN KEY (`Befreundet_Nummer`) REFERENCES Benutzer(Nummer)
);

CREATE TABLE `Gäste` (
	`Benutzer_Nummer` INT UNSIGNED,
	Grund VARCHAR(254) NOT NULL,
	AblaufDatum DATE NOT NULL DEFAULT (CURRENT_DATE + INTERVAL 1 WEEK),
 	PRIMARY KEY (`Benutzer_Nummer`),
 	FOREIGN KEY (`Benutzer_Nummer`) REFERENCES Benutzer(Nummer) ON DELETE CASCADE
);

CREATE TABLE FH_Angehörige (
	`Benutzer_Nummer` INT UNSIGNED,
 	PRIMARY KEY (`Benutzer_Nummer`),
 	FOREIGN KEY (`Benutzer_Nummer`) REFERENCES Benutzer(Nummer) ON DELETE CASCADE
);

CREATE TABLE Fachbereiche (
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	Website VARCHAR(255) NOT NULL,
	Name VARCHAR(255) NOT NULL,
	Addresse VARCHAR(255) NOT NULL,
	PRIMARY KEY (ID),
	UNIQUE (ID)
);

CREATE TABLE `gehörtZu` (
	Nummer_FH_Angehörige INT UNSIGNED,
	`Fachbereiche_ID` INT UNSIGNED,
	PRIMARY KEY (Nummer_FH_Angehörige,`Fachbereiche_ID`),
	FOREIGN KEY (Nummer_FH_Angehörige) REFERENCES FH_Angehörige(`Benutzer_Nummer`) ON DELETE CASCADE,
	FOREIGN KEY (`Fachbereiche_ID`) REFERENCES Fachbereiche(ID) ON DELETE CASCADE
);

CREATE TABLE Studenten (
	FH_Angehörige_Nummer INT UNSIGNED,
	Matrikelnummer INT(7) NOT NULL,
	Studiengang ENUM('ET','INF','ISE','MCD','WI') NOT NULL,
	PRIMARY KEY (FH_Angehörige_Nummer),
	FOREIGN KEY (FH_Angehörige_Nummer) REFERENCES FH_Angehörige(`Benutzer_Nummer`) ON DELETE CASCADE,
	UNIQUE (Matrikelnummer)
);

CREATE TABLE Mitarbeiter (
	FH_Angehörige_Nummer INT UNSIGNED,
	`Büro` VARCHAR(4),
	Telefon VARCHAR(15),
	PRIMARY KEY (FH_Angehörige_Nummer),
	FOREIGN KEY (FH_Angehörige_Nummer) REFERENCES FH_Angehörige(`Benutzer_Nummer`) ON DELETE CASCADE
);

CREATE TABLE Bestellungen (
	Nummer INT UNSIGNED AUTO_INCREMENT,
	BestellZeitpunkt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	Endpreis DECIMAL(4,2) DEFAULT '0.00' NOT NULL,
	AbholZeitpunkt DATETIME CHECK (AbholZeitpunkt > BestellZeitpunkt),
	PRIMARY KEY (Nummer),
	UNIQUE (Nummer)
);

CREATE TABLE IF NOT EXISTS Bilder (
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`Alt-Text` VARCHAR(255) NOT NULL,
	`Binärdaten` BLOB NOT NULL,
	Titel VARCHAR(255),
	PRIMARY KEY (ID),
	UNIQUE(ID)
);

CREATE TABLE Kategorien (
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	Bezeichnung VARCHAR(32) NOT NULL,
	`Bilder_ID` INT UNSIGNED,
	`Kategorien_ID` INT UNSIGNED,
	PRIMARY KEY (ID),
	FOREIGN KEY (`Bilder_ID`) REFERENCES Bilder (ID) ON DELETE SET NULL,
	FOREIGN KEY (`Kategorien_ID`) REFERENCES Kategorien(ID) ON DELETE SET NULL,
	UNIQUE (ID)
);

CREATE TABLE Mahlzeiten (
	ID INT UNSIGNED AUTO_INCREMENT,
	Beschreibung VARCHAR(255) NOT NULL,
	Name VARCHAR(50) NOT NULL,
	Vorrat INT UNSIGNED NOT NULL DEFAULT '0',
	`Kategorie_ID` INT UNSIGNED DEFAULT '3',
	`Verfügbar` BOOL DEFAULT (IF( Vorrat > 0, TRUE, FALSE)),
	PRIMARY KEY (ID),
	FOREIGN KEY (`Kategorie_ID`) REFERENCES Kategorien (ID),
	UNIQUE(ID)
);

CREATE TABLE `enthältM` (
	`Bestellungen_Nummer` INT UNSIGNED,
	`Mahlzeiten_ID` INT UNSIGNED,
	Anzahl INT UNSIGNED NOT NULL,
	PRIMARY KEY (`Bestellungen_Nummer`, `Mahlzeiten_ID`),
	FOREIGN KEY (`Bestellungen_Nummer`) REFERENCES Bestellungen (Nummer),
	FOREIGN KEY (`Mahlzeiten_ID`) REFERENCES Mahlzeiten (ID)
);

CREATE TABLE Deklarationen (
	Zeichen VARCHAR(2) NOT NULL,
	Beschriftung VARCHAR(32) NOT NULL,
	PRIMARY KEY (Zeichen)
);

CREATE TABLE brauchtD (
	`Deklarationen_Zeichen` VARCHAR(2),
	`Mahlzeiten_ID` INT UNSIGNED,
	PRIMARY KEY(`Mahlzeiten_ID`,`Deklarationen_Zeichen`),
	FOREIGN KEY (`Deklarationen_Zeichen`) REFERENCES Deklarationen (Zeichen),
	FOREIGN KEY (`Mahlzeiten_ID`) REFERENCES Mahlzeiten (ID)
);

CREATE TABLE Kommentare (
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`Studenten_Nummer` INT UNSIGNED,
	`Mahlzeiten_ID` INT UNSIGNED,
	Bewertung TINYINT(1) UNSIGNED NOT NULL,
	Bemerkung VARCHAR(255),
	Zeitpunkt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (ID),
	FOREIGN KEY (`Studenten_Nummer`) REFERENCES Studenten(FH_Angehörige_Nummer),
	CONSTRAINT `Mahlzeiten_ID_Constraint` FOREIGN KEY (`Mahlzeiten_ID`) REFERENCES Mahlzeiten(ID) ON DELETE SET NULL
);

CREATE TABLE Preise (
	`Mahlzeiten_ID` INT UNSIGNED,
	Gastpreis DECIMAL(4,2) UNSIGNED NOT NULL,
	Jahr YEAR NOT NULL DEFAULT YEAR(CURRENT_DATE),
	Studentpreis DECIMAL(4,2) UNSIGNED CHECK (Studentpreis < `MA-Preis`),
	`MA-Preis` DECIMAL(4,2) UNSIGNED CHECK (`MA-Preis` < Gastpreis),
	PRIMARY KEY (`Mahlzeiten_ID`, Jahr),
	FOREIGN KEY (`Mahlzeiten_ID`) REFERENCES Mahlzeiten (ID) ON DELETE CASCADE
);

CREATE TABLE Zutaten (
	ID INT(5) UNSIGNED NOT NULL,
	Name VARCHAR(32) NOT NULL,
	Bio BOOL NOT NULL,
	Vegetarisch BOOL NOT NULL,
	Vegan BOOL NOT NULL,
	Glutenfrei BOOL NOT NULL,
	PRIMARY KEY (ID),
	UNIQUE (ID)
);

CREATE TABLE enthältZ (
	`Zutaten_ID` INT UNSIGNED,
	`Mahlzeiten_ID` INT UNSIGNED,
	PRIMARY KEY (`Mahlzeiten_ID`,`Zutaten_ID`),
	FOREIGN KEY (`Zutaten_ID`) REFERENCES Zutaten (ID),
	FOREIGN KEY (`Mahlzeiten_ID`) REFERENCES Mahlzeiten (ID) ON DELETE CASCADE
);

CREATE TABLE hatB (
	`Bilder_ID` INT UNSIGNED,
	`Mahlzeiten_ID` INT UNSIGNED,
	PRIMARY KEY (`Mahlzeiten_ID`,`Bilder_ID`),
	FOREIGN KEY (`Bilder_ID`) REFERENCES Bilder (ID),
	FOREIGN KEY (`Mahlzeiten_ID`) REFERENCES Mahlzeiten (ID)
);

CREATE VIEW Benutzertyp AS
SELECT Benutzer.Benutzername, Benutzer.Nummer,
CASE 
	WHEN Benutzer.Nummer = Mitarbeiter.FH_Angehörige_Nummer THEN "Mitarbeiter"
	WHEN Benutzer.Nummer = Studenten.FH_Angehörige_Nummer THEN "Studierender"
	WHEN Benutzer.Nummer = Gäste.Benutzer_Nummer THEN "Gast"
	ELSE "Fehler"
END AS Typ
FROM Benutzer
LEFT JOIN Studenten ON Benutzer.Nummer = Studenten.FH_Angehörige_Nummer
LEFT JOIN Mitarbeiter ON Benutzer.Nummer = Mitarbeiter.FH_Angehörige_Nummer
LEFT JOIN Gäste ON Benutzer.Nummer = Gäste.Benutzer_Nummer;

INSERT INTO Kategorien(Bezeichnung) VALUES
('Generell'),
('Um die Welt');

INSERT INTO Kategorien(Bezeichnung,Kategorien_ID) VALUES
('Zeige Alle',1),
('Italenisch',2),
('Mexikanisch',2);

INSERT INTO Mahlzeiten (Name,Beschreibung,Vorrat,`Kategorie_ID`) VALUES
("Curry Wok","Nur erlesene Zutaten!",250,3),
("Schnitzel","Wiener Lebenselixir!",200,3),
("Bratrole","Deftig und lecker!",0,3),
("Krautsalat","Kulturgut!",135,3),
("Falafel","Vegetarisches Gedicht",230,3),
("Currywurst","Der Stadionklassiker serviert mit Pommes!",240,4),
("Käsestulle","Bleibt einfach immer lecker",450,3),
("Spiegelei","Sunny Side Up - wie es sein muss",300,5);

INSERT INTO Preise(`Mahlzeiten_ID`,Gastpreis) VALUES
(1,3.99),
(2,4.99),
(3,3.99),
(4,3.99),
(5,4.99),
(6,3.99),
(7,3.99),
(8,4.99);

INSERT INTO Zutaten(ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) VALUES
(1, "Kichererbsen", TRUE, TRUE, TRUE, TRUE),
(100, "Curry", TRUE, TRUE, TRUE, TRUE),
(123, "Weizenmehl", FALSE, TRUE, TRUE, FALSE),
(330, "Kohlkopf", TRUE, TRUE, TRUE, TRUE),
(1000, "Hühnerbrust", FALSE, FALSE, FALSE, TRUE),
(1015, "Essig", FALSE, TRUE, TRUE, TRUE),
(2101, "Ei", FALSE, TRUE, FALSE, TRUE),
(2105, "Pfeffer", FALSE, TRUE, TRUE, TRUE);

INSERT INTO enthältZ(`Zutaten_ID`,`Mahlzeiten_ID`) VALUES
(100,1),
(123,1),
(2105,1),
(2101,1),
(2101,2),
(1000,2),
(2101,3),
(1015,4),
(330,4),
(1,5),
(2101,6),
(100,6),
(123,7),
(2105,8),
(2101,8);

INSERT INTO hatB(`Bilder_ID`,`Mahlzeiten_ID`) VALUES
(1,1),
(2,2),
(3,3),
(4,4),
(5,5),
(6,6),
(7,7),
(8,8);

INSERT INTO Fachbereiche(Website,Name,Addresse) VALUES
('https://www.fh-aachen.de/fachbereiche/elektrotechnik-und-informationstechnik/','Elektrotechnik und Informationstechnik','Eupener Straße 70 52066 Aachen');


UPDATE Preise SET `MA-Preis` = Gastpreis * 0.9 WHERE `MA-Preis` IS NULL;
UPDATE Preise SET Studentpreis = `MA-Preis` * 0.5 WHERE Studentpreis IS NULL;
ALTER TABLE Kommentare DROP FOREIGN KEY `Mahlzeiten_ID_Constraint`;


SELECT Zutaten.Vegan, Mahlzeiten.ID 
		FROM Zutaten, enthältZ, Mahlzeiten 
		WHERE enthältZ.Zutaten_ID = Zutaten.ID AND enthältZ.Mahlzeiten_ID = Mahlzeiten.ID AND Zutaten.Vegan = 0
		GROUP BY Mahlzeiten.ID;

CREATE VIEW Mahlzeitentypen AS
SELECT m.ID, m.`Name`, m.Verfügbar, Kategorien.ID as Kategorie, Bilder.`Alt-Text`, Bilder.Binärdaten, Vegan.Vegan, Vegetarisch.Vegetarisch FROM Mahlzeiten m
	INNER JOIN hatB ON m.ID = hatB.Mahlzeiten_ID
	INNER JOIN Bilder ON hatB.Bilder_ID = Bilder.ID
	INNER JOIN Kategorien ON m.Kategorie_ID = Kategorien.ID
	LEFT JOIN (SELECT Zutaten.Vegan, Mahlzeiten.ID
		FROM Zutaten, enthältZ, Mahlzeiten
		WHERE Zutaten.ID = enthältZ.Zutaten_ID AND Mahlzeiten.ID = enthältZ.Mahlzeiten_ID AND Zutaten.Vegan = 0
		GROUP BY Mahlzeiten.ID) Vegan ON m.ID = Vegan.ID
	LEFT JOIN (SELECT Zutaten.Vegetarisch, Mahlzeiten.ID
		FROM Zutaten, enthältZ, Mahlzeiten 
		WHERE Zutaten.ID = enthältZ.Zutaten_ID AND Mahlzeiten.ID = enthältZ.Mahlzeiten_ID AND Zutaten.Vegetarisch = 0
		GROUP BY Mahlzeiten.ID) Vegetarisch ON m.ID = Vegetarisch.ID;

INSERT INTO Benutzer(Email,Benutzername,Bild,Vorname,Nachname,Aktiv,`Hash`,Geburtsdatum) VALUES
("mctom.77@gmx.de","mordrag",10101,"Tom","Weh",TRUE,"$2y$10$ubnTkCiUtIaoBFRlsTNSWee/GgDoddWtyoVEq9uarZ12osA4rJdUy","1965-4-12");

SELECT m.Beschreibung,m.`Name`, b.`Binärdaten`,p.`Gastpreis`,p.`MA-Preis` as Mitarbeiterpreis,p.Studentpreis as Studierendenpreis, b.`Alt-Text` 
            FROM Bilder b,Mahlzeiten m, Preise p, hatB mb
            WHERE m.ID = ' . $id . '
            AND m.ID = mb.Mahlzeiten_ID
            AND b.ID = mb.Bilder_ID
            AND p.Mahlzeiten_ID = m.ID;
           
DELIMITER $$
CREATE PROCEDURE korrekterPreis(IN Mahlzeit INT, IN Nummer INT)
BEGIN
SELECT
CASE
	WHEN Benutzertyp.Typ = "Mitarbeiter" THEN Preise.`MA-Preis`
	WHEN Benutzertyp.Typ = "Studierender" THEN Preise.Studentpreis
	ELSE Preise.Gastpreis
END AS Preis
FROM Mahlzeiten, Preise, Benutzertyp WHERE
Mahlzeiten.ID = Mahlzeit AND
Mahlzeiten.ID = Preise.Mahlzeiten_ID AND
Benutzertyp.Nummer = Nummer;
END $$
CALL korrekterPreis(1,1);
/*
SELECT opt_group.*, `option`.Bezeichnung as Option_Bezeichnung, `option`.Bilder_ID as Option_Bilder_ID, `option`.ID as Option_ID, `option`.Kategorien_ID as Option_Kategorien_ID
FROM Kategorien opt_group LEFT JOIN Kategorien `option` ON opt_group.ID = `option`.Kategorien_ID WHERE opt_group.Kategorien_ID IS NULL;

ALTER TABLE Kategorien DROP FOREIGN KEY `Kategorien_ID_Constraint`;
DELETE FROM Kategorien WHERE ID = 3;

INSERT INTO Benutzer(Email,Benutzername,Bild,Vorname,Nachname,Aktiv,`Hash`,Geburtsdatum) VALUES
("hans@gmx.de","Hansa33",10101,"Hans","Mueller",TRUE,"aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa","1965-4-12"),
("lisa95@web.de","xLiSax",10101,"Lisa","Krueger",TRUE,"aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa","1997-3-15"),
("leon@gmail.de","xXxLion",10101,"Leon","Schneider",TRUE,"aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa","2000-12-12");

INSERT INTO Benutzer(Email,Benutzername,Bild,Vorname,Nachname,Aktiv,`Hash`) VALUES
("rebekka@gmail.de","RebellKa",10101,"Rebekka","Roth",TRUE,"aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");

INSERT INTO `Gäste`(`Benutzer_Nummer`,Grund) VALUES
(4,"Studium gerade beendet!");

INSERT INTO Fachbereiche (Website,Name) VALUES
("www.fb5.com","FB5"),
("www.fb7.com","FB7");

INSERT INTO FH_Angehörige(`Benutzer_Nummer`) VALUES
(1),
(2),
(3);

INSERT INTO `gehörtZu` (Nummer_FH_Angehörige,`Fachbereiche_ID`) VALUES
(1,1),
(2,1),
(3,1);

INSERT INTO Studenten(FH_Angehörige_Nummer,Matrikelnummer,Studiengang) VALUES
(2,"31212339","ET"),
(3,"31347538","INF");

INSERT INTO Mitarbeiter(FH_Angehörige_Nummer,Büro,Telefon) VALUES
(1,"G203","016901234567");

DELETE FROM Benutzer WHERE Nummer = 2;
SELECT * FROM Benutzer, FH_Angehörige WHERE Benutzer.Nummer = FH_Angehörige.`Benutzer_Nummer`;

*/

/*
CREATE TRIGGER `Before_Mahlzeiten_Delete`
BEFORE DELETE ON Mahlzeiten
FOR EACH ROW
ALTER TABLE Kommentare
	DROP CONSTRAINT `Mahlzeiten_ID_Constraint` WHERE Mahlzeiten.ID = Kommentare.`Mahlzeiten_ID`;

CREATE TRIGGER `Before_Kategorien_Delete`
BEFORE DELETE ON Kategorien
FOR EACH ROW
ALTER TABLE Kategorien
	DROP CONSTRAINT `Kategorien_ID_Constraint` WHERE Kategorien.ID = Kategorien.`Kategorien_ID`;

UPDATE Benutzer SET `Alter` = TIMESTAMPDIFF(YEAR, Geburtsdatum, CURRENT_DATE) WHERE Geburtsdatum IS NOT NULL;
UPDATE `Gäste` SET AblaufDatum = CURRENT_DATE + INTERVAL 1 WEEK;
UPDATE Bestellungen SET AbholZeitpunkt = BestellZeitpunkt + INTERVAL 1 HOUR WHERE AbholZeitpunkt IS NOT NULL AND AbholZeitpunkt <= BestellZeitpunkt;


CREATE TRIGGER `after_gaeste_insert` BEFORE INSERT ON `Gäste` FOR EACH ROW
UPDATE `Gäste`
	SET AblaufDatum = CURRENT_DATE() + INTERVAL 1 WEEK;
*/
