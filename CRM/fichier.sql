-- Table client
CREATE TABLE client (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    telephone VARCHAR(20),
    password VARCHAR(20),
    date_creation DATE
);

INSERT INTO `client` (`id`, `nom`, `prenom`, `email`, `telephone`, `password`, `date_creation`) VALUES
(1, 'client', 'client', 'chennoufwail@gmail.com', '0754591689', 'wail', CURDATE());

-- Table vendeur
CREATE TABLE vendeur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    telephone VARCHAR(20),
    password VARCHAR(20),
    wilaya VARCHAR(20),
    bureau VARCHAR(20),
    date_creation DATE
);

INSERT INTO `vendeur` (`id`, `nom`, `prenom`, `email`, `telephone`, `wilaya`, `password`, `bureau`, `date_creation`) VALUES 
(1, 'vendeur', 'vendeur', 'yahiabdelhak7@gmail.com', '0754506598', `fouka`, 'wail', 'dilvrili chlef', CURDATE());

-- Table chef de bureau 
CREATE TABLE chef_de_bureau ( 
    id INT PRIMARY KEY AUTO_INCREMENT, 
    nom VARCHAR(100), 
    prenom VARCHAR(100), 
    email VARCHAR(100), 
    telephone VARCHAR(20), 
    bureau VARCHAR(100), 
    password VARCHAR(20) 
);


INSERT INTO `chef_de_bureau` (`id`, `nom`, `prenom`, `email`, `telephone`, `bureau`, `password`) VALUES 
(1, 'chef', 'chef', 'iyedbelm@gmail.com', '0531587541', 'alger', 'wail');

-- Table admin
CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    telephone VARCHAR(20),
    password VARCHAR(20)
);

INSERT INTO `admin` (`id`, `nom`, `prenom`, `email`, `telephone`, `password`) VALUES 
(1, 'admin', 'admin', 'akramaymen7@gmail.com', '0754591689', 'wail');

-- Table commande
CREATE TABLE commande (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT,
    id_vendeur INT,
    date_commande DATE,
    montant DECIMAL(10, 2),
    FOREIGN KEY (id_client) REFERENCES client(id),
    FOREIGN KEY (id_vendeur) REFERENCES vendeur(id)
);

-- Table paiement
CREATE TABLE Paiement (
    id INT PRIMARY KEY AUTO_INCREMENT,
    wilaya VARCHAR(100),
    utilisateur VARCHAR(100),
    catégorie VARCHAR(100),
    Prix DECIMAL(10, 2),
    Prix_livraison DECIMAL(10, 2),
    status VARCHAR(100),
    date_creation DATE
);

INSERT INTO `Paiement` (`wilaya`, `utilisateur`, `catégorie`, `Prix`, `Prix_livraison`, `status`, `date_creation`) VALUES 
('alger', 'Delivrili Alger', 'facteur', '2000.00', '850.00', 'initialisation', CURDATE());

-- Table comptable
CREATE TABLE comptable (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    telephone VARCHAR(20),
    bureau VARCHAR(100),
    password VARCHAR(20)
);

INSERT INTO `comptable` (`id`, `nom`, `prenom`, `email`, `telephone`, `bureau`, `password`) VALUES 
(1, 'compt', 'compt', 'chennoufwail01@gmail.com', '075786564', 'alger', 'wail');

-- Table livreur
CREATE TABLE livreur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    telephone VARCHAR(100),
    bureau VARCHAR(100),
    date_creation DATE,
    password VARCHAR(20)
);

INSERT INTO livreur (`nom`, `prenom`, `email`, `telephone`, `bureau`, `date_creation`, `password`) 
VALUES ('livreur', 'livreur', 'chennoufwail03@gmail.com', '0554552767', 'delivri_chlef', CURDATE(), 'wail');

-- Table produit
CREATE TABLE produit (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    prix DECIMAL(10, 2)
);

INSERT INTO `produit` (`id`, `nom`, `prix`) 
VALUES (1, 'prod', '2000.00');

-- Table colis
CREATE TABLE colis (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_vendeur INT,
    id_produit INT,
    wilaya VARCHAR(100),
    wilaya_destination VARCHAR(100),
    prix_total DECIMAL(10, 2),
    paiement VARCHAR(20),
    option VARCHAR(100),
    status VARCHAR(100),
    date_creation DATE,
    FOREIGN KEY (id_vendeur) REFERENCES vendeur(id),
    FOREIGN KEY (id_produit) REFERENCES produit(id)
);

INSERT INTO `colis` (`id_vendeur`, `id_produit`,`wilaya`, `wilaya_destination`, `prix_total`,`option`, `status`, `date_creation`, `paiement`)
VALUES (1, 1, 'tipaza','Algiers', '2000.00','annuler','En attente', CURDATE(), 'initialisation');

-- Requête pour obtenir le nom du vendeur au lieu de son ID dans la table colis
SELECT colis.id, vendeur.nom AS nom_vendeur, colis.id_produit, colis.wilaya_destination, colis.prix_total, colis.date_creation, colis.paiement
FROM colis
INNER JOIN vendeur ON colis.id_vendeur = vendeur.id;
