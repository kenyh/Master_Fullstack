CREATE TABLE platform (
    "platformId" SERIAL PRIMARY KEY,
    "name" TEXT NOT NULL UNIQUE
);

CREATE TABLE person (
    "personId" INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name TEXT NOT NULL,
    surname TEXT NOT NULL,
    birthday DATE,
    nationality TEXT
);

CREATE TABLE directors (
    "personId" INTEGER PRIMARY KEY,
    CONSTRAINT "directors_personId_fk"
        FOREIGN KEY ("personId")
        REFERENCES person ("personId")
        ON DELETE CASCADE
);

CREATE TABLE actors (
    "personId" INTEGER PRIMARY KEY,
    CONSTRAINT "actors_personId_fk" 
        FOREIGN KEY ("personId") 
        REFERENCES person ("personId") 
        ON DELETE CASCADE
        ON UPDATE CASCADE
);