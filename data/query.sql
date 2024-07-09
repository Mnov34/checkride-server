/* Création des user / admin via le site directement */

/* Jeu de donée pour le projet checkride*/

INSERT INTO motorcycle (brand, model, cylinder, prod_year, plate, acquisition_date, Id_checkride_user) VALUES
    ('Honda', 'CBR500R', '500cc', '2019-01-01', 'DG-451-XE', '2020-01-15', 1),
    ('Yamaha', 'MT-07', '689cc', '2018-03-01', 'MF-882-GT', '2020-02-20', 1),
    ('Kawasaki', 'Z650', '649cc', '2020-05-01', 'KP-203-RT', '2020-06-30', 2),
    ('Suzuki', 'GSX-S750', '749cc', '2019-07-01', 'XJ-908-CR', '2020-08-15', 2),
    ('BMW', 'R1250GS', '1254cc', '2021-01-01', 'LB-567-MQ', '2021-03-01', 3),
    ('Ducati', 'Monster 821', '821cc', '2020-02-01', 'OZ-314-PL', '2021-04-20', 3),
    ('Triumph', 'Street Triple', '765cc', '2020-11-01', 'EQ-426-VB', '2021-05-30', 4),
    ('Aprilia', 'RS 660', '659cc', '2021-06-01', 'UT-759-HD', '2021-07-15', 4),
    ('Moto Guzzi', 'V85 TT', '853cc', '2019-08-01', 'AJ-672-FS', '2021-09-01', 5),
    ('Harley Davidson', 'Iron 883', '883cc', '2018-04-01', 'VC-185-KY', '2021-10-20', 5);

INSERT INTO maintenance (maintenance_kilometer, parts, bills, maintenance_date, Id_motorcycle)
VALUES
    (500, 'Engine oil', 'Invoice_001.pdf', '2021-01-15', 1),
    (500, 'Oil filter', 'Invoice_041.pdf', '2021-01-15', 1),
    (2000, 'Air filter', 'Invoice_002.pdf', '2022-01-15', 1),
    (5000, 'Front tires', 'Invoice_003.pdf', '2023-01-15', 1),
    (7500, 'Brake pads', 'Invoice_004.pdf', '2024-01-15', 1),
    (10000, 'Engine oil', 'Invoice_005.pdf', '2024-01-15', 1),
    (10000, 'Oil filter', 'Invoice_042.pdf', '2024-01-15', 1),

    (500, 'Engine oil', 'Invoice_006.pdf', '2021-02-20', 2),
    (500, 'Oil filter', 'Invoice_043.pdf', '2021-02-20', 2),
    (1500, 'Oil filter', 'Invoice_007.pdf', '2022-02-20', 2),
    (4000, 'Chain', 'Invoice_008.pdf', '2023-02-20', 2),
    (7000, 'Air filter', 'Invoice_009.pdf', '2024-02-20', 2),
    (10000, 'Engine oil', 'Invoice_010.pdf', '2024-02-20', 2),
    (10000, 'Oil filter', 'Invoice_044.pdf', '2024-02-20', 2),

    (1000, 'Engine oil', 'Invoice_011.pdf', '2021-06-30', 3),
    (1000, 'Oil filter', 'Invoice_045.pdf', '2021-06-30', 3),
    (3000, 'Oil filter', 'Invoice_012.pdf', '2022-06-30', 3),
    (5000, 'Rear tires', 'Invoice_013.pdf', '2023-06-30', 3),
    (8000, 'Brake pads', 'Invoice_014.pdf', '2024-06-30', 3),
    (10000, 'Engine oil', 'Invoice_015.pdf', '2024-06-30', 3),
    (10000, 'Oil filter', 'Invoice_046.pdf', '2024-06-30', 3),

    (500, 'Engine oil', 'Invoice_016.pdf', '2021-08-15', 4),
    (500, 'Oil filter', 'Invoice_047.pdf', '2021-08-15', 4),
    (2500, 'Air filter', 'Invoice_017.pdf', '2022-08-15', 4),
    (5000, 'Front tires', 'Invoice_018.pdf', '2023-08-15', 4),
    (7500, 'Brake pads', 'Invoice_019.pdf', '2024-08-15', 4),
    (10000, 'Engine oil', 'Invoice_020.pdf', '2024-08-15', 4),
    (10000, 'Oil filter', 'Invoice_048.pdf', '2024-08-15', 4),

    (1000, 'Engine oil', 'Invoice_023.pdf', '2022-03-01', 5),
    (1000, 'Oil filter', 'Invoice_049.pdf', '2022-03-01', 5),
    (3000, 'Oil filter', 'Invoice_024.pdf', '2023-03-01', 5),
    (6000, 'Air filter', 'Invoice_025.pdf', '2024-03-01', 5),
    (9000, 'Front tires', 'Invoice_026.pdf', '2025-03-01', 5),
    (12000, 'Brake pads', 'Invoice_027.pdf', '2025-03-01', 5),

    (1500, 'Engine oil', 'Invoice_029.pdf', '2022-04-20', 6),
    (1500, 'Oil filter', 'Invoice_050.pdf', '2022-04-20', 6),
    (4000, 'Oil filter', 'Invoice_030.pdf', '2023-04-20', 6),
    (7000, 'Rear tires', 'Invoice_031.pdf', '2024-04-20', 6),
    (10000, 'Chain', 'Invoice_032.pdf', '2025-04-20', 6),
    (13000, 'Brake pads', 'Invoice_033.pdf', '2025-04-20', 6),
    (15000, 'Engine oil', 'Invoice_034.pdf', '2025-04-20', 6),
    (15000, 'Oil filter', 'Invoice_051.pdf', '2025-04-20', 6);




INSERT INTO kilometers (date_kilometer, kilometer, Id_motorcycle) VALUES
      ('2021-01-15', 500, 1),
      ('2021-03-18', 1000, 1),
      ('2021-06-28', 1500, 1),
      ('2022-01-15', 2000, 1),
      ('2022-03-18', 3000, 1),
      ('2022-06-28', 4000, 1),
      ('2023-01-15', 5000, 1),
      ('2023-03-18', 6000, 1),
      ('2023-06-28', 6500, 1),
      ('2024-01-15', 7500, 1),
      ('2024-03-18', 8000, 1),
      ('2024-04-28', 9500, 1),
      ('2024-05-30', 10000, 1),

      ('2021-02-20', 500, 2),
      ('2021-03-18', 1000, 2),
      ('2021-06-28', 1500, 2),
      ('2022-01-15', 2000, 2),
      ('2022-03-18', 3000, 2),
      ('2022-06-28', 4000, 2),
      ('2023-01-15', 5000, 2),
      ('2023-03-18', 6000, 2),
      ('2023-06-28', 6500, 2),
      ('2024-01-15', 7500, 2),
      ('2024-03-18', 8000, 2),
      ('2024-04-28', 9500, 2),
      ('2024-05-30', 10000, 2),

      ('2021-06-30', 500, 3),
      ('2021-07-18', 1000, 3),
      ('2021-11-28', 1500, 3),
      ('2022-01-15', 2000, 3),
      ('2022-03-18', 3000, 3),
      ('2022-06-28', 4000, 3),
      ('2023-01-15', 5000, 3),
      ('2023-03-18', 6000, 3),
      ('2023-06-28', 6500, 3),
      ('2024-01-15', 7500, 3),
      ('2024-03-18', 8000, 3),
      ('2024-04-28', 9500, 3),
      ('2024-05-30', 10000, 3),

      ('2021-08-15', 500, 4),
      ('2021-09-18', 1000, 4),
      ('2021-12-28', 1500, 4),
      ('2022-01-15', 2000, 4),
      ('2022-03-18', 3000, 4),
      ('2022-06-28', 4000, 4),
      ('2023-01-15', 5000, 4),
      ('2023-03-18', 6000, 4),
      ('2023-06-28', 6500, 4),
      ('2024-01-15', 7500, 4),
      ('2024-03-18', 8000, 4),
      ('2024-04-28', 9500, 4),
      ('2024-05-30', 10000, 4),

      ('2022-03-11', 500, 5),
      ('2022-06-15', 2000, 5),
      ('2022-07-18', 3000, 5),
      ('2022-011-28', 4000, 5),
      ('2023-01-15', 5000, 5),
      ('2023-03-18', 6000, 5),
      ('2023-06-28', 6500, 5),
      ('2024-01-15', 7500, 5),
      ('2024-03-18', 8000, 5),
      ('2024-04-28', 9500, 5),
      ('2024-05-30', 10000, 5),

      ('2022-04-20', 500, 6),
      ('2022-06-15', 2000, 6),
      ('2022-07-18', 3000, 6),
      ('2022-011-28', 4000, 6),
      ('2023-01-15', 5000, 6),
      ('2023-03-18', 6000, 6),
      ('2023-06-28', 6500, 6),
      ('2024-01-15', 7500, 6),
      ('2024-03-18', 8000, 6),
      ('2024-04-28', 9500, 6),
      ('2024-05-30', 10000, 6);


/* modification à faire pour la suppréssion des utilisateurs */

ALTER TABLE motorcycle
    DROP FOREIGN KEY motorcycle_ibfk_1;
ALTER TABLE motorcycle
    ADD CONSTRAINT motorcycle_ibfk_1 FOREIGN KEY (Id_checkride_user) REFERENCES checkride_user (Id_checkride_user) ON DELETE CASCADE;
