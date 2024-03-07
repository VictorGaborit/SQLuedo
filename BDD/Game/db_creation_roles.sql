/* Création de l'utilisateur permettant de gérer la base de données SQLuedo */

CREATE USER admin IDENTIFIED BY 'motdepasse';
GRANT ALL PRIVILEGES ON *.* TO admin WITH GRANT OPTION;

/* Création de l'utilisateur player qui va exécuter les requêtes des utilisateurs */

CREATE USER player IDENTIFIED BY 'motdepasse';