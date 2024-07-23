INSERT INTO Event (event_name, event_venue, prefix) VALUES
  ('ICT Event Tuguegarao', 'Cagayan State University', 'Cagayan24'),
  ('ICT Event Cauayan', 'Isabela State University', 'Isabela24');

INSERT INTO Timeslots (timestart, timeend, event_id) VALUES
  ('2024-08-09 08:00:00', '2024-08-09 08:30:00', 2),
  ('2024-08-09 08:30:00', '2024-08-09 09:00:00', 2),
  ('2024-08-09 09:00:00', '2024-08-09 09:30:00', 2),
  ('2024-08-09 09:30:00', '2024-08-09 10:00:00', 2),
  ('2024-08-09 10:00:00', '2024-08-09 10:30:00', 2),
  ('2024-08-09 10:30:00', '2024-08-09 11:00:00', 2),
  ('2024-08-09 11:00:00', '2024-08-09 11:30:00', 2),
  ('2024-08-09 11:30:00', '2024-08-09 12:00:00', 2),
  ('2024-08-08 13:00:00', '2024-08-08 13:30:00', 1),
  ('2024-08-08 13:30:00', '2024-08-08 14:00:00', 1),
  ('2024-08-08 14:00:00', '2024-08-08 14:30:00', 1),
  ('2024-08-08 14:30:00', '2024-08-08 15:00:00', 1),
  ('2024-08-08 15:00:00', '2024-08-08 15:30:00', 1),
  ('2024-08-08 15:30:00', '2024-08-08 16:00:00', 1),
  ('2024-08-08 16:00:00', '2024-08-08 16:30:00', 1),
  ('2024-08-08 16:30:00', '2024-08-08 17:00:00', 1);

-- Password is 'adminpassword'
INSERT INTO Booths (topic, presentor, event_id, email, password) VALUES
  ('Teleperformance', 'Teleperformance', 1, "admin+1@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('iRhythm', 'iRhythm', 1, "admin+2@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Everise', 'Everise', 1, "admin+3@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Cognizant', 'Cognizant', 1, "admin+4@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Alorica', 'Alorica', 1, "admin+5@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Accenture', 'Accenture', 1, "admin+6@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Company 7', 'Company 7', 1, "admin+7@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Company 8', 'Company 8', 1, "admin+8@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Company 9', 'Company 9', 1, "admin+9@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Company 10', 'Company 10', 1, "admin+10@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Teleperformance', 'Teleperformance', 2, "admin+11@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('iRhythm', 'iRhythm', 2, "admin+12@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Everise', 'Everise', 2, "admin+13@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Cognizant', 'Cognizant', 2, "admin+14@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Alorica', 'Alorica', 2, "admin+15@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Accenture', 'Accenture', 2, "admin+16@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Company 7', 'Company 7', 2, "admin+17@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Company 8', 'Company 8', 2, "admin+18@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Company 9', 'Company 9', 2, "admin+19@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Company 10', 'Company 10', 2, "admin+20@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy");
