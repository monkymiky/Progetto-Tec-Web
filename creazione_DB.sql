drop table if exists Gift_card;
drop table if exists Tipo_giftcard;
drop table if exists Prenotazioni;
drop table if exists Dati_cliente;
drop table if exists Disponibilità;

CREATE TABLE Tipo_giftcard(
    Tipo VARCHAR(20) PRIMARY KEY,
    Descrizione VARCHAR(500),
    Utilizzi_possibili INT NOT NULL
);

CREATE TABLE Gift_card (
	SHA_256 VARCHAR(256) PRIMARY KEY,
	Utilizzi INT NOT NULL,
	Tipo VARCHAR(20) NOT NULL,
	FOREIGN KEY (Tipo) REFERENCES Tipo_giftcard(Tipo)
);

CREATE TABLE Dati_cliente(
    Email VARCHAR(50) PRIMARY KEY,
    Cellulare VARCHAR(15) NOT NULL,
    Indirizzo VARCHAR(50),
    Nome VARCHAR(20) NOT NULL
);

CREATE TABLE Prenotazioni(
    Data_Ora_Inizio DATETIME PRIMARY KEY,
    Tipo BOOLEAN NOT NULL, -- true = 1,5 h (in studio) | false = 3h (a domicilio)
    InfoAggiuntive VARCHAR(500),
    Cliente INT NOT NULL,
    FOREIGN KEY (Cliente) REFERENCES Dati_cliente(Email)
);

CREATE TABLE Disponibilità(
    Data_Ora_Inizio DATETIME PRIMARY KEY CHECK (
        Data_Ora_Inizio NOT IN (SELECT Data_Ora_Inizio FROM Prenotazioni)
        AND ADDTIME(Data_Ora_Inizio, "-1:30:0") NOT IN (SELECT Data_Ora_Inizio FROM Prenotazioni WHERE Tipo = false)
        ),
);
CREATE TABLE Login(
    Username VARCHAR(20) PRIMARY KEY,
    Pass VARCHAR(256) NOT NULL
);


