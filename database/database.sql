
drop table infotherminal_schema;
drop table schemas;
drop table infotherminals; 

 

CREATE DATABASE dbTerminal
; 




USE dbTerminal;
CREATE TABLE infotherminals (
    id INT NOT NULL IDENTITY(1,1),
    titel VARCHAR(50),
    ipAdresse VARCHAR(50),
    CONSTRAINT PK_infotherminals PRIMARY KEY (id)
);

CREATE TABLE schemas (
    id INT NOT NULL IDENTITY(1,1),
    imagePath VARCHAR(255),
    selectedTime VARCHAR(50),
    isAktiv VARCHAR(1),
    startTime VARCHAR(50),
    endTime VARCHAR(50),
    startDateTime VARCHAR(50),
    endDateTime VARCHAR(50),
    timeAktiv VARCHAR(1),
    dateAktiv VARCHAR(1), 
    titel VARCHAR(50),
    beschreibung VARCHAR(255),
    CONSTRAINT PK_schemas PRIMARY KEY (id)  -- <- Klammer fehlte hier
);

CREATE TABLE infotherminal_schema (
    id INT NOT NULL IDENTITY(1,1),
    fk_infotherminal_id INT NOT NULL,
    fk_schema_id INT NOT NULL,
    CONSTRAINT PK_infotherminal_schema PRIMARY KEY (fk_infotherminal_id, fk_schema_id),
    CONSTRAINT FK_infotherminal_schema_infotherminals FOREIGN KEY (fk_infotherminal_id) 
        REFERENCES infotherminals(id),
    CONSTRAINT FK_infotherminal_schema_schemas FOREIGN KEY (fk_schema_id) 
        REFERENCES schemas(id)
);
