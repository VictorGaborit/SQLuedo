DROP TABLE IF EXISTS Success;
DROP TABLE IF EXISTS Notepad;
DROP TABLE IF EXISTS Inquiry;
DROP TABLE IF EXISTS Blacklist;
DROP TABLE IF EXISTS ContentLesson;
DROP TABLE IF EXISTS Lesson;
DROP TABLE IF EXISTS Paragraph;
DROP TABLE IF EXISTS InquiryTable;
DROP TABLE IF EXISTS Solution;
DROP TABLE IF EXISTS User;


CREATE TABLE User
(
    id       INT          NOT NULL AUTO_INCREMENT,
    username VARCHAR(40)  NOT NULL,
    password VARCHAR(200) NOT NULL,
    email    VARCHAR(70)  NOT NULL,
    is_admin BOOLEAN      NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (username(40)),
    UNIQUE (email(70))
) ENGINE = InnoDB;


CREATE TABLE Solution
(
    `id`                int NOT NULL,
    `murder_first_name` varchar(30)   DEFAULT NULL,
    `murder_name`       varchar(30)   DEFAULT NULL,
    `explanation`       varchar(1000) DEFAULT NULL,
    `place`             varchar(100)  DEFAULT NULL,
    `murder_weapon`     varchar(50)   DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;


CREATE TABLE InquiryTable
(
    `inquiry_id`      int NOT NULL,
    `database_name`   varchar(100) DEFAULT NULL,
    `connection_info` varchar(255) DEFAULT NULL,
    PRIMARY KEY (inquiry_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS Paragraph
(
    id                INT AUTO_INCREMENT,
    paragraph_title   VARCHAR(70)  DEFAULT NULL,
    paragraph_content VARCHAR(500) DEFAULT NULL,
    info              VARCHAR(200) DEFAULT NULL,
    query             VARCHAR(200) DEFAULT NULL,
    comment           VARCHAR(200) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS Lesson
(
    id             INTEGER AUTO_INCREMENT PRIMARY KEY,
    title          VARCHAR(70),
    last_edit      DATE         DEFAULT NULL,
    last_publisher VARCHAR(120) DEFAULT NULL
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS ContentLesson
(
    lesson      INTEGER,
    lesson_part INTEGER,
    PRIMARY KEY (`lesson`, lesson_part),
    FOREIGN KEY (`lesson`) REFERENCES Lesson (`id`),
    FOREIGN KEY (lesson_part) REFERENCES Paragraph (`id`)
) ENGINE = InnoDB;


CREATE TABLE Blacklist
(
    email           varchar(70) NOT NULL,
    expiration_date date DEFAULT NULL,
    PRIMARY KEY (`email`)
) ENGINE = InnoDB;


CREATE TABLE Inquiry
(
    `id`          int NOT NULL,
    `title`       varchar(300) DEFAULT NULL,
    `description` text,
    `is_user`     tinyint(1)   DEFAULT '0',
    `database`    int,
    `solution`    int,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`database`) REFERENCES InquiryTable (inquiry_id),
    FOREIGN KEY (`solution`) REFERENCES Solution (id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;


CREATE TABLE Notepad
(
    id         INT NOT NULL AUTO_INCREMENT,
    user_id    INT NOT NULL,
    inquiry_id INT NOT NULL,
    notes      TEXT,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES User (id),
    FOREIGN KEY (inquiry_id) REFERENCES Inquiry (id)
) ENGINE = InnoDB;


CREATE TABLE Success
(
    user_id    int     NOT NULL,
    inquiry_id int     NOT NULL,
    is_finish  boolean NOT NULL,
    PRIMARY KEY (user_id, inquiry_id),
    FOREIGN KEY (user_id) REFERENCES User (id),
    FOREIGN KEY (inquiry_id) REFERENCES Inquiry (id)
) Engine = INNODB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

-- STUB
INSERT INTO Solution (id, murder_first_name, murder_name, explanation, place, murder_weapon)
VALUES (1, 'Emily', 'Navy', 'text', 'Bureau de Richard', 'Tubocurarine'),
       (2, 'Jacob', 'Filambour', 'text', 'place', 'poison'),
       (3, 'Blist', 'Carros', 'text', 'place', 'poison');


INSERT INTO InquiryTable (inquiry_id, database_name, connection_info)
VALUES (1, 'Inquiry1', CONCAT('mysql:host=localhost;dbname=', database_name, inquiry_id));

INSERT INTO InquiryTable (inquiry_id, database_name, connection_info)
VALUES (2, 'Inquiry2', CONCAT('mysql:host=localhost;dbname=', database_name, inquiry_id));

INSERT INTO InquiryTable (inquiry_id, database_name, connection_info)
VALUES (3, 'Inquiry3', CONCAT('mysql:host=localhost;dbname=', database_name, inquiry_id));


INSERT INTO `Paragraph` (`id`, `paragraph_title`, `paragraph_content`, `info`, `query`, `comment`)
VALUES (1, 'SELECT : Utilisation classique',
        'L’utilisation la plus courante de SQL consiste à lire des données issues de la base de données. Cela s’effectue grâce à la commande SELECT, qui retourne des enregistrements dans un tableau de résultat. Cette commande peut sélectionner une ou plusieurs colonnes d’une table.',
        'L’utilisation basique de cette commande s’effectue de la manière suivante :',
        'SELECT nom_du_champ FROM nom_du_tableau',
        'Cette requête SQL va sélectionner (SELECT) le champ “nom_du_champ” provenant (FROM) du tableau appelé “nom_du_tableau”.'),
       (2, 'Autre titre', 'Autre leçon', 'Autre information', 'SELECT autre_champ FROM autre_tableau',
        'Autre résultat');


INSERT INTO `Lesson` (`title`, `last_edit`, `last_publisher`)
VALUES ('Les selects', '2023-11-11', 'Clément'),
       ('Default', '2023-12-11', 'Akas');


INSERT INTO `ContentLesson` (`lesson`, `lesson_part`)
VALUES (1, 1),
       (2, 2);


INSERT INTO `Inquiry` (`id`, title, `description`, `is_user`, `database`, `solution`)
VALUES (1, 'Meurtre à Rosewood',
        'Rosewood, une ville perdue au fin fond des états-unis d’Amérique, est secouée par un crime horrible qui s’est déroulé la nuit dernière. Le très connu manoir de la famille Thornton a été victime d’un meurtre qui secoua toute la ville. La victime, Richard Thornton, un grand homme d’affaires, a été retrouvé mort. Les enquêteurs sont perplexes et font appel à vos talents de détective. Les premières investigations indiquent que les membres de la famille étaient présents. Parmi eux se trouve sa femme Margaret, sa fille Elizabeth et son fils William. De plus, des témoins ont signalé des bruits durant la nuit du meutre mais personne n’a vu qui est entré ou sorti du manoir.\r\nLes enquêteurs cherchent à interroger les membres de la famille ainsi que le personnel du manoir présents le soir du meurtre. Ils rassemblent des preuves en plus telles que les  enregistrements caméras de sécurité et les appels téléphoniques. Ils font donc appel à vos services pour résoudre cette enquête avec les données qu’ils ont enregistrés dans des bases de données.',
        0, 1, 1),
       (2, 'Titre 2', 'Description 2', 0, 2, 2),
       (3, 'Titre 3', 'Description 3', 1, 3, 3);