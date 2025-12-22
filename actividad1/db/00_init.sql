CREATE TABLE platforms (
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
    "directorId" INTEGER PRIMARY KEY,
    CONSTRAINT "directors_personId_fk"
        FOREIGN KEY ("directorId")
        REFERENCES person ("personId")
        ON DELETE CASCADE
);

CREATE TABLE actors (
    "actorId" INTEGER PRIMARY KEY,
    CONSTRAINT "actors_personId_fk" 
        FOREIGN KEY ("actorId") 
        REFERENCES person ("personId") 
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE series (
    "serieId" INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    title TEXT NOT NULL,
    "platformId" INTEGER NOT NULL,
    "directorId" INTEGER NOT NULL,
    CONSTRAINT "series_platformId_fk" FOREIGN KEY ("platformId") REFERENCES platforms("platformId"),
    CONSTRAINT "series_directorId_fk" FOREIGN KEY ("directorId") REFERENCES directors("directorId")
);

CREATE TABLE serie_actors (
    "serieId" INTEGER NOT NULL,
    "actorId"  INTEGER NOT NULL,

    CONSTRAINT "serie_actors_pk" PRIMARY KEY ("serieId", "actorId"),

    CONSTRAINT "serie_actors_series_fk" FOREIGN KEY ("serieId") REFERENCES series("serieId")
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT "serie_actors_actor_fk" FOREIGN KEY ("actorId") REFERENCES actors("actorId")
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- 
CREATE TABLE languages (
    "languageId" INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name TEXT NOT NULL,
    iso_code TEXT NOT NULL,
    CONSTRAINT language_iso_code_uk UNIQUE (iso_code)
);

CREATE TABLE series_audio_languages (
    "serieId"   INTEGER NOT NULL,
    "languageId" INTEGER NOT NULL,

    CONSTRAINT "series_audio_languages_pk" PRIMARY KEY ("serieId", "languageId"),

    CONSTRAINT "series_audio_languages_series_fk" FOREIGN KEY ("serieId") REFERENCES series("serieId")
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT "series_audio_languages_language_fk" FOREIGN KEY ("languageId") REFERENCES languages("languageId")
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE series_subtitle_languages (
    "serieId"   INTEGER NOT NULL,
    "languageId" INTEGER NOT NULL,

    CONSTRAINT "series_subtitle_languages_pk" PRIMARY KEY ("serieId", "languageId"),

    CONSTRAINT "series_subtitle_languages_serieId_fk" FOREIGN KEY ("serieId") REFERENCES series("serieId")
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT "series_subtitle_languages_languageId_fk" FOREIGN KEY ("languageId") REFERENCES languages("languageId")
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
