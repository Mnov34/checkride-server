CREATE TABLE checkride_user(
                               Id_checkride_user INT AUTO_INCREMENT,
                               CR_user VARCHAR(255) ,
                               CR_password VARCHAR(255) ,
                               PRIMARY KEY(Id_checkride_user)
);

CREATE TABLE owner(
                      Id_owner INT AUTO_INCREMENT,
                      firstname VARCHAR(50) ,
                      lastname VARCHAR(255) ,
                      email VARCHAR(255) ,
                      nb_motorcycle TINYINT,
                      username VARCHAR(255) ,
                      phone VARCHAR(20) ,
                      Id_checkride_user INT NOT NULL,
                      PRIMARY KEY(Id_owner),
                      FOREIGN KEY(Id_checkride_user) REFERENCES checkride_user(Id_checkride_user)
);

CREATE TABLE motorcycle(
                           Id_motorcycle INT AUTO_INCREMENT,
                           brand VARCHAR(50) ,
                           model VARCHAR(50) ,
                           cylinder VARCHAR(50) ,
                           prod_year DATE,
                           plate VARCHAR(50) ,
                           acquisition_date DATE,
                           Id_owner INT NOT NULL,
                           PRIMARY KEY(Id_motorcycle),
                           FOREIGN KEY(Id_owner) REFERENCES owner(Id_owner)
);

CREATE TABLE maintenance(
                            Id_maintenance INT AUTO_INCREMENT,
                            maintenance_kilometer SMALLINT,
                            parts VARCHAR(50) ,
                            bills VARCHAR(50) ,
                            maintenance_date DATE,
                            Id_motorcycle INT NOT NULL,
                            PRIMARY KEY(Id_maintenance),
                            FOREIGN KEY(Id_motorcycle) REFERENCES motorcycle(Id_motorcycle)
);

CREATE TABLE parts(
                      Id_piece INT AUTO_INCREMENT,
                      name_part VARCHAR(50) ,
                      Id_motorcycle INT NOT NULL,
                      PRIMARY KEY(Id_piece),
                      FOREIGN KEY(Id_motorcycle) REFERENCES motorcycle(Id_motorcycle)
);

CREATE TABLE kilometers(
                           Id_kilometer INT AUTO_INCREMENT,
                           date_kilometer DATE,
                           kilometer INT,
                           Id_motorcycle INT NOT NULL,
                           PRIMARY KEY(Id_kilometer),
                           FOREIGN KEY(Id_motorcycle) REFERENCES motorcycle(Id_motorcycle)
);
