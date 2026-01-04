CREATE TABLE platforms (
    platform_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    CONSTRAINT platforms_name_uk UNIQUE (name),
    CONSTRAINT platforms_name_chk CHECK (CHAR_LENGTH(name) >= 2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE people (
    person_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    birthday DATE,
    nationality VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE directors (
    director_id INT PRIMARY KEY,
    CONSTRAINT directors_person_id_fk
        FOREIGN KEY (director_id)
        REFERENCES people (person_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE actors (
    actor_id INT PRIMARY KEY,
    CONSTRAINT actors_person_id_fk
        FOREIGN KEY (actor_id)
        REFERENCES people (person_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE series (
    serie_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    platform_id INT NOT NULL,
    director_id INT NOT NULL,
    CONSTRAINT series_platform_id_fk
        FOREIGN KEY (platform_id)
        REFERENCES platforms (platform_id),
    CONSTRAINT series_director_id_fk
        FOREIGN KEY (director_id)
        REFERENCES directors (director_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE serie_actors (
    serie_id INT NOT NULL,
    actor_id INT NOT NULL,
    CONSTRAINT serie_actors_pk PRIMARY KEY (serie_id, actor_id),
    CONSTRAINT serie_actors_series_fk
        FOREIGN KEY (serie_id)
        REFERENCES series (serie_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT serie_actors_actor_fk
        FOREIGN KEY (actor_id)
        REFERENCES actors (actor_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE languages (
    language_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    iso_code CHAR(2) NOT NULL,
    CONSTRAINT languages_name_uk UNIQUE (name),
    CONSTRAINT languages_iso_code_uk UNIQUE (iso_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE series_audio_languages (
    serie_id INT NOT NULL,
    language_id INT NOT NULL,
    CONSTRAINT series_audio_languages_pk PRIMARY KEY (serie_id, language_id),
    CONSTRAINT series_audio_languages_series_fk
        FOREIGN KEY (serie_id)
        REFERENCES series (serie_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT series_audio_languages_language_fk
        FOREIGN KEY (language_id)
        REFERENCES languages (language_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE series_subtitle_languages (
    serie_id INT NOT NULL,
    language_id INT NOT NULL,
    CONSTRAINT series_subtitle_languages_pk PRIMARY KEY (serie_id, language_id),
    CONSTRAINT series_subtitle_languages_serie_id_fk
        FOREIGN KEY (serie_id)
        REFERENCES series (serie_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT series_subtitle_languages_language_id_fk
        FOREIGN KEY (language_id)
        REFERENCES languages (language_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB;
