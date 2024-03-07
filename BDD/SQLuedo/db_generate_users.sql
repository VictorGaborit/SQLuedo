DROP PROCEDURE IF EXISTS GenerateUsers;

-- Crée une procédure stockée pour générer des utilisateurs aléatoires
DELIMITER //
CREATE PROCEDURE GenerateUsers()
BEGIN
    DECLARE i INT DEFAULT 1;

    WHILE i <= 200
        DO
            -- Génère un nom d'utilisateur et une adresse e-mail uniques
            SET @username = CONCAT('user', i);
            SET @email = CONCAT('user', i, '@example.com');
            SET @password = 'password123';
            -- Vous pouvez générer un mot de passe aléatoire si nécessaire

            -- Insère l'utilisateur dans la table User
            INSERT INTO User (username, password, email, is_admin) VALUES (@username, @password, @email, 0);

            SET i = i + 1;
        END WHILE;
END //
DELIMITER ;

CALL GenerateUsers();


-- permet d'afficher la liste des procedure dans la base de donnée 

SHOW PROCEDURE STATUS;
