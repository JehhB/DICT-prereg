INSERT INTO Event (event_name, event_venue, prefix) VALUES
  ('ICT Event Tuguegarao', 'Cagayan State University', 'Cagayan24'),
  ('ICT Event Cauayan', 'Isabela State University', 'Isabela24');

INSERT INTO Timeslots (timestart, timeend, event_id) VALUES
  ('2024-08-05 08:00:00', '2024-08-05 08:30:00', 2),
  ('2024-08-05 08:30:00', '2024-08-05 09:00:00', 2),
  ('2024-08-05 09:00:00', '2024-08-05 09:30:00', 2),
  ('2024-08-05 09:30:00', '2024-08-05 10:00:00', 2),
  ('2024-08-05 10:00:00', '2024-08-05 10:30:00', 2),
  ('2024-08-05 10:30:00', '2024-08-05 11:00:00', 2),
  ('2024-08-05 11:00:00', '2024-08-05 11:30:00', 2),
  ('2024-08-05 11:30:00', '2024-08-05 12:00:00', 2),
  ('2024-08-05 13:00:00', '2024-08-05 13:30:00', 1),
  ('2024-08-05 13:30:00', '2024-08-05 14:00:00', 1),
  ('2024-08-05 14:00:00', '2024-08-05 14:30:00', 1),
  ('2024-08-05 14:30:00', '2024-08-05 15:00:00', 1),
  ('2024-08-05 15:00:00', '2024-08-05 15:30:00', 1),
  ('2024-08-05 15:30:00', '2024-08-05 16:00:00', 1),
  ('2024-08-05 16:00:00', '2024-08-05 16:30:00', 1),
  ('2024-08-05 16:30:00', '2024-08-05 17:00:00', 1);

INSERT INTO Booths (topic, presentor, event_id) VALUES
  ('Teleperformance', 'Teleperformance', 1),
  ('iRhythm', 'iRhythm', 1),
  ('Everise', 'Everise', 1),
  ('Cognizant', 'Cognizant', 1),
  ('Alorica', 'Alorica', 1),
  ('Accenture', 'Accenture', 1),
  ('Company 7', 'Company 7', 1),
  ('Company 8', 'Company 8', 1),
  ('Company 9', 'Company 9', 1),
  ('Company 10', 'Company 10', 1),
  ('Teleperformance', 'Teleperformance', 2),
  ('iRhythm', 'iRhythm', 2),
  ('Everise', 'Everise', 2),
  ('Cognizant', 'Cognizant', 2),
  ('Alorica', 'Alorica', 2),
  ('Accenture', 'Accenture', 2),
  ('Company 7', 'Company 7', 2),
  ('Company 8', 'Company 8', 2),
  ('Company 9', 'Company 9', 2),
  ('Company 10', 'Company 10', 2);


INSERT INTO BoothRegistration (timeslot_id, booth_id) VALUES
  (1, 11),
  (1, 11),
  (1, 11);
