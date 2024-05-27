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

INSERT INTO maintenance (maintenance_kilometer, parts, bills, maintenance_date, Id_motorcycle) VALUES
   (500, 'Oil change', 'Bill001', '2022-01-10', 1),
   (1000, 'Tire replacement', 'Bill002', '2022-03-15', 1),
   (1500, 'Brake pads', 'Bill003', '2022-05-20', 1),
   (2000, 'Battery replacement', 'Bill004', '2022-07-25', 1),
   (2500, 'Chain and sprockets', 'Bill005', '2022-09-30', 1),
   (3000, 'Spark plug replacement', 'Bill006', '2022-11-05', 1),
   (3500, 'Air filter', 'Bill007', '2023-01-09', 1),
   (4000, 'Oil and filter change', 'Bill008', '2023-03-14', 1),
   (4500, 'Coolant flush', 'Bill009', '2023-05-19', 1),
   (5000, 'General inspection', 'Bill010', '2023-07-24', 1);

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
