INSERT INTO checkride_user (CR_user, CR_password, email, status) VALUES
     ('user1', 'pass1', 'user1@example.com', 'user'),
     ('user2', 'pass2', 'user2@example.com', 'user'),
     ('user3', 'pass3', 'user3@example.com', 'user'),
     ('user4', 'pass4', 'user4@example.com', 'user');

INSERT INTO motorcycle (brand, model, cylinder, prod_year, plate, acquisition_date, Id_checkride_user) VALUES
    ('Honda', 'CBR500R', '500cc', '2019-01-01', 'DG-451-XE', '2020-01-15', 1),
    ('Yamaha', 'MT-07', '689cc', '2018-03-01', 'MF-882-GT', '2020-02-20', 2),
    ('Kawasaki', 'Z650', '649cc', '2020-05-01', 'KP-203-RT', '2020-06-30', 3),
    ('Suzuki', 'GSX-S750', '749cc', '2019-07-01', 'XJ-908-CR', '2020-08-15', 4),
    ('BMW', 'R1250GS', '1254cc', '2021-01-01', 'LB-567-MQ', '2021-03-01', 1),
    ('Ducati', 'Monster 821', '821cc', '2020-02-01', 'OZ-314-PL', '2021-04-20', 2),
    ('Triumph', 'Street Triple', '765cc', '2020-11-01', 'EQ-426-VB', '2021-05-30', 3),
    ('Aprilia', 'RS 660', '659cc', '2021-06-01', 'UT-759-HD', '2021-07-15', 4),
    ('Moto Guzzi', 'V85 TT', '853cc', '2019-08-01', 'AJ-672-FS', '2021-09-01', 1),
    ('Harley Davidson', 'Iron 883', '883cc', '2018-04-01', 'VC-185-KY', '2021-10-20', 2);

INSERT INTO maintenance (maintenance_kilometer, parts, bills, maintenance_date, Id_motorcycle)
VALUES
    (500, 'Engine oil', 'Invoice_001.pdf', '2024-01-15', 1),
    (2000, 'Air filter', 'Invoice_002.pdf', '2024-03-10', 1),
    (5000, 'Front tires', 'Invoice_003.pdf', '2024-06-20', 1),
    (7500, 'Brake pads', 'Invoice_004.pdf', '2024-09-15', 1),
    (10000, 'Engine oil', 'Invoice_005.pdf', '2024-12-01', 1),

    (500, 'Engine oil', 'Invoice_006.pdf', '2024-01-20', 2),
    (1500, 'Oil filter', 'Invoice_007.pdf', '2024-02-25', 2),
    (4000, 'Chain', 'Invoice_008.pdf', '2024-05-30', 2),
    (7000, 'Air filter', 'Invoice_009.pdf', '2024-08-25', 2),
    (10000, 'Engine oil', 'Invoice_010.pdf', '2024-11-20', 2),

    (1000, 'Engine oil', 'Invoice_011.pdf', '2024-02-05', 3),
    (3000, 'Oil filter', 'Invoice_012.pdf', '2024-04-15', 3),
    (5000, 'Rear tires', 'Invoice_013.pdf', '2024-06-25', 3),
    (8000, 'Brake pads', 'Invoice_014.pdf', '2024-09-30', 3),
    (10000, 'Engine oil', 'Invoice_015.pdf', '2024-11-30', 3),

    (500, 'Engine oil', 'Invoice_016.pdf', '2024-01-10', 4),
    (2500, 'Air filter', 'Invoice_017.pdf', '2024-03-05', 4),
    (5000, 'Front tires', 'Invoice_018.pdf', '2024-05-10', 4),
    (7500, 'Brake pads', 'Invoice_019.pdf', '2024-07-20', 4),
    (10000, 'Engine oil', 'Invoice_020.pdf', '2024-09-25', 4),
    (12500, 'Chain', 'Invoice_021.pdf', '2024-11-30', 4),
    (15000, 'Rear tires', 'Invoice_022.pdf', '2025-02-05', 4),

    (1000, 'Engine oil', 'Invoice_023.pdf', '2024-01-15', 5),
    (3000, 'Oil filter', 'Invoice_024.pdf', '2024-03-10', 5),
    (6000, 'Air filter', 'Invoice_025.pdf', '2024-05-15', 5),
    (9000, 'Front tires', 'Invoice_026.pdf', '2024-07-20', 5),
    (12000, 'Brake pads', 'Invoice_027.pdf', '2024-10-10', 5),
    (15000, 'Engine oil', 'Invoice_028.pdf', '2025-01-05', 5),

    (1500, 'Engine oil', 'Invoice_029.pdf', '2024-02-01', 6),
    (4000, 'Oil filter', 'Invoice_030.pdf', '2024-04-15', 6),
    (7000, 'Rear tires', 'Invoice_031.pdf', '2024-06-30', 6),
    (10000, 'Chain', 'Invoice_032.pdf', '2024-09-10', 6),
    (13000, 'Brake pads', 'Invoice_033.pdf', '2024-11-20', 6),
    (15000, 'Engine oil', 'Invoice_034.pdf', '2025-02-28', 6);



INSERT INTO kilometers (date_kilometer, kilometer, Id_motorcycle) VALUES
  ('2024-01-01', 1000, 1),
  ('2024-01-15', 1100, 1),
  ('2024-02-10', 1500, 1),
  ('2024-03-05', 1700, 1),
  ('2024-03-20', 2000, 1),
  ('2024-04-10', 2200, 1),
  ('2024-04-25', 2400, 1),
  ('2024-05-15', 2600, 1),
  ('2024-05-30', 2800, 1),
  ('2024-06-20', 3000, 1),
  ('2024-07-10', 3200, 1),
  ('2024-07-25', 3400, 1),
  ('2024-08-15', 3500, 1),
  ('2024-10-01', 3700, 1),
  ('2025-01-01', 4000, 1),
  ('2025-04-01', 4200, 1);
