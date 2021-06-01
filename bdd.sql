#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE Utilisateur(
        Numero          Int  Auto_increment  NOT NULL ,
        Nom             Varchar (50) NOT NULL ,
        Prenom          Varchar (50) NOT NULL ,
        Mail            Varchar (50) NOT NULL ,
        Adresse_postale Varchar (50) NOT NULL ,
        Admin           Bool NOT NULL
	,CONSTRAINT Utilisateur_PK PRIMARY KEY (Numero)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Filtre
#------------------------------------------------------------

CREATE TABLE Filtre(
        Id   Int  Auto_increment  NOT NULL ,
        Name Varchar (50) NOT NULL
	,CONSTRAINT Filtre_PK PRIMARY KEY (Id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: souscrit
#------------------------------------------------------------

CREATE TABLE souscrit(
        Id     Int NOT NULL ,
        Numero Int NOT NULL
	,CONSTRAINT souscrit_PK PRIMARY KEY (Id,Numero)

	,CONSTRAINT souscrit_Filtre_FK FOREIGN KEY (Id) REFERENCES Filtre(Id)
	,CONSTRAINT souscrit_Utilisateur0_FK FOREIGN KEY (Numero) REFERENCES Utilisateur(Numero)
)ENGINE=InnoDB;

