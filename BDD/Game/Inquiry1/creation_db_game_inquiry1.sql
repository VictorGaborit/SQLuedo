SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `witness`,`footprint`,`security_video`,`Phone_call`,`suspect`;
CREATE TABLE IF NOT EXISTS `suspect`
(
    `id`                   int(8)                                    NOT NULL,
    `first_name`           varchar(30) COLLATE utf8mb4_general_ci    NOT NULL,
    `name`                 varchar(30) COLLATE utf8mb4_general_ci    NOT NULL,
    `gender`               enum ('M','F') COLLATE utf8mb4_general_ci NOT NULL,
    `age`                  int                                       NOT NULL,
    `physical_description` varchar(1000) COLLATE utf8mb4_general_ci  NOT NULL,
    `alibi`                varchar(1000) COLLATE utf8mb4_general_ci  NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `victim`,`position`,`place`;
CREATE TABLE IF NOT EXISTS `place`
(
    `id`                int                                      NOT NULL,
    `place_name`        varchar(50) COLLATE utf8mb4_general_ci   NOT NULL,
    `place_description` varchar(2000) COLLATE utf8mb4_general_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;


DROP TABLE IF EXISTS `object`;
CREATE TABLE IF NOT EXISTS `object`
(
    `id`                 int                                     NOT NULL,
    `object_name`        varchar(40) COLLATE utf8mb4_general_ci  NOT NULL,
    `object_description` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `phone_call`
(
    `id`             int(10) NOT NULL,
    `suspect_caller` int     NOT NULL,
    `suspect_called` int     NOT NULL,
    `hour`           time    NOT NULL,
    `discussion`     varchar(3000) COLLATE utf8mb4_general_ci DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`suspect_caller`) REFERENCES suspect (id) ON DELETE CASCADE,
    FOREIGN KEY (`suspect_called`) REFERENCES suspect (id) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `footprint`
(
    `id`                int(12)                                 NOT NULL,
    `footprint_type`    varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
    `suspect_footprint` int                                     NOT NULL,
    `object_concerned`  int                                     NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`suspect_footprint`) REFERENCES suspect (id) ON DELETE CASCADE,
    FOREIGN KEY (`object_concerned`) REFERENCES object (id) ON DELETE CASCADE
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4
    COLLATE = utf8mb4_general_ci;



DROP TABLE IF EXISTS `player`;
CREATE TABLE IF NOT EXISTS `player`
(
    `username` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
    `score`    int                                    NOT NULL,
    `progress` int                                    NOT NULL,
    PRIMARY KEY (`username`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;



CREATE TABLE IF NOT EXISTS `position`
(
    `object_place`     int  NOT NULL,
    `object_concerned` int  NOT NULL,
    `hour`             time NOT NULL,
    PRIMARY KEY (`object_place`, `object_concerned`, `hour`),
    FOREIGN KEY (`object_place`) REFERENCES place (id) ON DELETE CASCADE,
    FOREIGN KEY (`object_concerned`) REFERENCES object (id) ON DELETE CASCADE
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4
    COLLATE = utf8mb4_general_ci;



CREATE TABLE IF NOT EXISTS `witness`
(
    `id`              int                                    NOT NULL,
    `name`            varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
    `testimony`       varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `testimonal_date` datetime                               NOT NULL,
    `accused_suspect` int                                      DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`accused_suspect`) REFERENCES suspect (id) ON DELETE CASCADE
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4
    COLLATE = utf8mb4_general_ci;



CREATE TABLE IF NOT EXISTS `victim`
(
    `id`          int                                     NOT NULL,
    `name`        varchar(50) COLLATE utf8mb4_general_ci  NOT NULL,
    `cause_death` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
    `date_death`  datetime                                NOT NULL,
    `death_place` int                                     NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`death_place`) REFERENCES place (id) ON DELETE CASCADE
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4
    COLLATE = utf8mb4_general_ci;



CREATE TABLE IF NOT EXISTS `security_video`
(
    `recording_id`   int  NOT NULL,
    `seen_suspect`   int  NOT NULL,
    `recorded_place` int  NOT NULL,
    `hour`           time NOT NULL,
    PRIMARY KEY (`recording_id`),
    FOREIGN KEY (`recorded_place`) REFERENCES place (id) ON DELETE CASCADE,
    FOREIGN KEY (`seen_suspect`) REFERENCES suspect (id) ON DELETE CASCADE
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4
    COLLATE = utf8mb4_general_ci;
COMMIT;