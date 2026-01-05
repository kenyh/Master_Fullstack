CREATE TABLE platforms (
    platform_id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    CONSTRAINT platforms_name_uk UNIQUE (name),
    CONSTRAINT platforms_name_chk CHECK (CHAR_LENGTH(name) >= 2)
);

CREATE TABLE people (
    person_id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    birthday DATE,
    nationality VARCHAR(100)
);

CREATE TABLE directors (
    director_id INTEGER PRIMARY KEY,
    CONSTRAINT directors_person_id_fk FOREIGN KEY (director_id) REFERENCES people (person_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE actors (
    actor_id INTEGER PRIMARY KEY,
    CONSTRAINT actors_person_id_fk FOREIGN KEY (actor_id)  REFERENCES people (person_id) 
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE series (
    serie_id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    synopsis VARCHAR(500) NOT NULL,
    platform_id INTEGER NOT NULL,
    director_id INTEGER NOT NULL,
    CONSTRAINT series_platform_id_fk FOREIGN KEY (platform_id) REFERENCES platforms(platform_id),
    CONSTRAINT series_director_id_fk FOREIGN KEY (director_id) REFERENCES directors(director_id),
    CONSTRAINT series_synopsis_chk CHECK (CHAR_LENGTH(synopsis) >= 20),
    CONSTRAINT series_title_chk CHECK (CHAR_LENGTH(title) >= 1)
);

CREATE TABLE serie_actors (
    serie_id INTEGER NOT NULL,
    actor_id  INTEGER NOT NULL,

    CONSTRAINT serie_actors_pk PRIMARY KEY (serie_id, actor_id),

    CONSTRAINT serie_actors_series_fk FOREIGN KEY (serie_id) REFERENCES series(serie_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT serie_actors_actor_fk FOREIGN KEY (actor_id) REFERENCES actors(actor_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE languages (
    language_id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    iso_code CHAR(2) NOT NULL,
    CONSTRAINT languages_name_uk UNIQUE (name),
    CONSTRAINT languages_iso_code_uk UNIQUE (iso_code)
);

CREATE TABLE series_audio_languages (
    serie_id INTEGER NOT NULL,
    language_id INTEGER NOT NULL,

    CONSTRAINT series_audio_languages_pk PRIMARY KEY (serie_id, language_id),

    CONSTRAINT series_audio_languages_series_fk FOREIGN KEY (serie_id) REFERENCES series(serie_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
        
    CONSTRAINT series_audio_languages_language_fk FOREIGN KEY (language_id) REFERENCES languages(language_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE series_subtitle_languages (
    serie_id INTEGER NOT NULL,
    language_id INTEGER NOT NULL,

    CONSTRAINT series_subtitle_languages_pk PRIMARY KEY (serie_id, language_id),

    CONSTRAINT series_subtitle_languages_serie_id_fk FOREIGN KEY (serie_id) REFERENCES series(serie_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT series_subtitle_languages_language_id_fk FOREIGN KEY (language_id) REFERENCES languages(language_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);
