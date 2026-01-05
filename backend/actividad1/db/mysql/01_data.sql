SET NAMES 'utf8mb4';
SET CHARACTER SET utf8mb4;

INSERT INTO platforms (name) VALUES
('Netflix'),
('HBO Max'),
('Amazon Prime Video'),
('Disney+'),
('Apple TV+'),
('Fox'),
('CBS')
;

INSERT INTO people (name, surname, birthday, nationality) VALUES
-- Director genérico
('Director', 'Desconocido', '1969-11-20', 'American'),
-- Prison Break
('Paul', 'Scheuring', '1969-11-20', 'American'),
('Wentworth', 'Miller', '1972-06-02', 'American'),
('Dominic', 'Purcell', '1970-02-17', 'British'),
-- Spartacus
('Steven', 'S. DeKnight', '1965-10-08', 'American'),
('Andy', 'Whitfield', '1974-10-17', 'Australian'),
('Liam', 'McIntyre', '1982-02-08', 'Australian'),
-- Breaking Bad / Better Call Saul
('Vince', 'Gilligan', '1967-02-10', 'American'),
('Bryan', 'Cranston', '1956-03-07', 'American'),
('Aaron', 'Paul', '1979-08-27', 'American'),
('Bob', 'Odenkirk', '1962-10-22', 'American'),
-- Lie to Me
('Samuel', 'Baum', '1960-10-04', 'American'),
('Tim', 'Roth', '1961-05-14', 'British'),
-- The Wire
('David', 'Simon', '1960-02-09', 'American'),
('Dominic', 'West', '1969-10-15', 'British'),
('Idris', 'Elba', '1972-09-06', 'British'),
-- Sherlock
('Mark', 'Gatiss', '1966-10-17', 'British'),
('Steven', 'Moffat', '1961-11-18', 'British'),
('Benedict', 'Cumberbatch', '1976-07-19', 'British'),
('Martin', 'Freeman', '1971-09-08', 'British'),
-- Dexter
('James', 'Manos Jr.', '1958-08-15', 'American'),
('Michael', 'C. Hall', '1971-02-01', 'American'),
-- Peaky Blinders
('Steven', 'Knight', '1959-10-05', 'British'),
('Cillian', 'Murphy', '1976-05-25', 'Irish'),
-- Game of Thrones
('David', 'Benioff', '1970-09-25', 'American'),
('D. B.', 'Weiss', '1971-04-23', 'American'),
('Emilia', 'Clarke', '1986-10-23', 'British'),
('Kit', 'Harington', '1986-12-26', 'British'),
-- Hawaii Five-0
('Peter', 'Lenkov', '1964-02-14', 'Canadian'),
('Alex', 'OLoughlin', '1976-08-24', 'Australian'),
-- Dr House
('David', 'Shore', '1959-07-03', 'Canadian'),
('Hugh', 'Laurie', '1959-06-11', 'British'),
-- Daredevil
('Drew', 'Goddard', '1975-02-26', 'American'),
('Charlie', 'Cox', '1982-12-15', 'British'),
-- Arrow / Flash
('Greg', 'Berlanti', '1972-05-24', 'American'),
('Stephen', 'Amell', '1981-05-08', 'Canadian'),
('Grant', 'Gustin', '1990-01-14', 'American'),
-- Mindhunter
('Joe', 'Penhall', '1967-05-01', 'American'),
('Jonathan', 'Groff', '1985-03-26', 'American'),
-- The Crown
('Peter', 'Morgan', '1963-04-10', 'British'),
('Claire', 'Foy', '1984-04-16', 'British'),
-- Vikings
('Michael', 'Hirst', '1952-09-21', 'British'),
('Travis', 'Fimmel', '1979-07-15', 'Australian'),
-- Suits
('Aaron', 'Korsh', '1969-06-07', 'American'),
('Gabriel', 'Macht', '1972-01-22', 'American'),
('Patrick', 'J. Adams', '1981-08-27', 'Canadian')
;


INSERT INTO directors (director_id) VALUES
(1),  -- Desconocido
(2),  -- Paul Scheuring
(5),  -- Steven S. DeKnight
(8),  -- Vince Gilligan
(12), -- Samuel Baum
(14), -- David Simon
(17), -- Mark Gatiss
(18), -- Steven Moffat
(21), -- James Manos Jr.
(23), -- Steven Knight
(25), -- David Benioff
(26), -- D. B. Weiss
(29), -- Peter Lenkov
(31), -- David Shore
(33), -- Drew Goddard
(35), -- Greg Berlanti
(38), -- Joe Penhall
(40), -- Peter Morgan
(42), -- Michael Hirst
(44); -- Aaron Korsh

INSERT INTO actors (actor_id) VALUES
(1),  -- Desconocido es director y actor
-- Prison Break
(3),(4),
-- Spartacus
(6),(7),
-- Breaking Bad / BCS
(9),(10),(11),
-- Lie to Me
(13),
-- The Wire
(15),(16),
-- Sherlock
(19),(20),
-- Dexter
(22),
-- Peaky Blinders
(24),
-- Game of Thrones
(27),(28),
-- Hawaii Five-0
(30),
-- Dr House
(32),
-- Daredevil
(34),
-- Arrow / Flash
(36),(37),
-- Mindhunter
(39),
-- The Crown
(41),
-- Vikings
(43),
-- Suits
(45),(46)
;


INSERT INTO series (title, synopsis, platform_id, director_id) VALUES
(
  'Prison Break',
  'Un ingeniero brillante se deja encarcelar deliberadamente para ayudar a su hermano, condenado a muerte injustamente. Dentro de la prisión, ejecuta un plan de escape complejo lleno de alianzas, traiciones y giros inesperados.',
  6, 2
),
(
  'Spartacus',
  'Inspirada en hechos reales, sigue la vida de un gladiador tracio que lidera una rebelión de esclavos contra la República romana, combinando acción brutal, intrigas políticas y drama intenso.',
  3, 5
),
(
  'Breaking Bad',
  'Un profesor de química diagnosticado con cáncer terminal comienza a fabricar metanfetamina para asegurar el futuro económico de su familia, transformándose gradualmente en un peligroso criminal.',
  1, 8
),
(
  'Better Call Saul',
  'Precuela de Breaking Bad que narra la transformación de Jimmy McGill, un abogado con buenas intenciones, en Saul Goodman, mientras se hunde en el mundo del crimen y la corrupción legal.',
  1, 8
),
(
  'Lie to Me',
  'Un experto en lenguaje corporal y microexpresiones colabora con agencias gubernamentales para descubrir mentiras en investigaciones criminales y casos de alto riesgo.',
  6, 12
),
(
  'The Wire',
  'Un retrato crudo y realista de la ciudad de Baltimore, explorando el narcotráfico, la policía, la política, los medios y el sistema educativo desde múltiples perspectivas.',
  2, 14
),
(
  'Sherlock',
  'Una versión moderna de Sherlock Holmes, un detective brillante y excéntrico que resuelve crímenes complejos en Londres con la ayuda de su leal amigo John Watson.',
  2, 18
),
(
  'Dexter',
  'Dexter Morgan es un analista forense que lleva una doble vida como asesino en serie, siguiendo un estricto código moral para eliminar criminales impunes.',
  2, 21
),
(
  'Peaky Blinders',
  'Ambientada en la Inglaterra de posguerra, sigue a la familia Shelby y su líder Tommy mientras expanden su imperio criminal entre violencia, política y ambición.',
  1, 23
),
(
  'Game of Thrones',
  'Varias casas nobles luchan por el control del Trono de Hierro en un mundo fantástico lleno de traiciones, guerras, dragones y conspiraciones.',
  2, 25
),
(
  'Hawaii Five-0',
  'Un equipo especial de élite investiga crímenes graves en Hawái, combinando acción, drama policial y paisajes paradisíacos.',
  7, 29
),
(
  'Dr. House',
  'El doctor Gregory House, un médico brillante pero antisocial, lidera un equipo que diagnostica enfermedades raras usando métodos poco convencionales.',
  7, 31
),
(
  'Daredevil',
  'Matt Murdock, un abogado ciego con sentidos extraordinarios, combate el crimen en Hell’s Kitchen tanto en los tribunales como en las calles.',
  4, 33
),
(
  'Arrow',
  'Tras sobrevivir a un naufragio, un millonario regresa a su ciudad convertido en un justiciero encapuchado que combate el crimen y la corrupción.',
  4, 35
),
(
  'Flash',
  'Barry Allen obtiene supervelocidad tras un accidente científico y la usa para proteger su ciudad de amenazas metahumanas.',
  4, 35
),
(
  'Mindhunter',
  'Ambientada en los años 70, sigue a agentes del FBI que entrevistan asesinos seriales para comprender su psicología y mejorar la criminología moderna.',
  1, 38
),
(
  'The Crown',
  'Drama histórico que narra el reinado de Isabel II, explorando los desafíos políticos y personales de la monarquía británica.',
  1, 40
),
(
  'Vikings',
  'La serie sigue a Ragnar Lothbrok y sus descendientes en sus conquistas, exploraciones y conflictos en la era vikinga.',
  3, 42
),
(
  'Suits',
  'Un joven brillante sin título universitario consigue trabajo en un prestigioso bufete de abogados, ocultando su secreto mientras enfrenta casos complejos.',
  1, 44
);


INSERT INTO serie_actors (serie_id, actor_id) VALUES
-- Prison Break
(1, 3),
(1, 4),

-- Spartacus
(2, 6),
(2, 7),

-- Breaking Bad
(3, 9),
(3, 10),

-- Better Call Saul
(4, 11),

-- Lie to Me
(5, 13),

-- The Wire
(6, 15),
(6, 16),

-- Sherlock
(7, 19),
(7, 20),

-- Dexter
(8, 22),

-- Peaky Blinders
(9, 24),

-- Game of Thrones
(10, 27),
(10, 28),

-- Hawaii Five-0
(11, 30),

-- Dr. House
(12, 32),

-- Daredevil
(13, 34),

-- Arrow
(14, 36),

-- Flash
(15, 37),

-- Mindhunter
(16, 39),

-- The Crown
(17, 41),

-- Vikings
(18, 43),

-- Suits
(19, 45),
(19, 46)
;

-- Languages
INSERT INTO languages (name, iso_code) VALUES
('English', 'en'),
('Spanish', 'es'),
('Portuguese', 'pt'),
('French', 'fr'),
('German', 'de'),
('Italian', 'it'),
('Chinese', 'zh'),
('Japanese', 'ja'),
('Korean', 'ko'),
('Hindi', 'hi')
;


INSERT INTO series_audio_languages (serie_id, language_id) VALUES
-- Prison Break
(1, 1), (1, 2), (1, 3),

-- Spartacus
(2, 1), (2, 2),

-- Breaking Bad
(3, 1), (3, 2), (3, 3),

-- Better Call Saul
(4, 1), (4, 2),

-- Lie to Me
(5, 1), (5, 2),

-- The Wire
(6, 1), (6, 2),

-- Sherlock
(7, 1), (7, 2), (7, 4),

-- Dexter
(8, 1), (8, 2),

-- Peaky Blinders
(9, 1), (9, 2), (9, 4),

-- Game of Thrones
(10, 1), (10, 2), (10, 4), (10, 5),

-- Hawaii Five-0
(11, 1), (11, 2),

-- Dr. House
(12, 1), (12, 2), (12, 3),

-- Daredevil
(13, 1), (13, 2), (13, 3),

-- Arrow
(14, 1), (14, 2),

-- Flash
(15, 1), (15, 2),

-- Mindhunter
(16, 1), (16, 2),

-- The Crown
(17, 1), (17, 4),

-- Vikings
(18, 1), (18, 2), (18, 4),

-- Suits
(19, 1), (19, 2)
;


INSERT INTO series_subtitle_languages (serie_id, language_id) VALUES
-- Prison Break
(1, 1), (1, 2), (1, 3), (1, 4),

-- Spartacus
(2, 1), (2, 2), (2, 4),

-- Breaking Bad
(3, 1), (3, 2), (3, 3), (3, 4),

-- Better Call Saul
(4, 1), (4, 2), (4, 4),

-- Lie to Me
(5, 1), (5, 2), (5, 4),

-- The Wire
(6, 1), (6, 2), (6, 4),

-- Sherlock
(7, 1), (7, 2), (7, 4), (7, 5),

-- Dexter
(8, 1), (8, 2), (8, 4),

-- Peaky Blinders
(9, 1), (9, 2), (9, 4), (9, 5),

-- Game of Thrones
(10, 1), (10, 2), (10, 4), (10, 5),

-- Hawaii Five-0
(11, 1), (11, 2), (11, 4),

-- Dr. House
(12, 1), (12, 2), (12, 3), (12, 4),

-- Daredevil
(13, 1), (13, 2), (13, 3), (13, 4),

-- Arrow
(14, 1), (14, 2), (14, 4),

-- Flash
(15, 1), (15, 2), (15, 4),

-- Mindhunter
(16, 1), (16, 2), (16, 4),

-- The Crown
(17, 1), (17, 4), (17, 5),

-- Vikings
(18, 1), (18, 2), (18, 4), (18, 5),

-- Suits
(19, 1), (19, 2), (19, 4)
;
