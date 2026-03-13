USE concession_db;

CREATE TABLE IF NOT EXISTS voitures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marque VARCHAR(50),
    modele VARCHAR(50),
    annee INT
);

CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255),
    role VARCHAR(20)
);

INSERT INTO voitures (marque, modele, annee) VALUES 
('Toyota', 'Yaris', 2022),
('Tesla', 'Model 3', 2023),
('Renault', 'Clio', 2019);

INSERT INTO utilisateurs (username, password, role) VALUES 
('admin', 'SuperSecretPassword123!', 'admin'),
('rh_manager', 'Pa$$w0rd_RH', 'rh');