INSERT INTO Event (event_name, event_venue, prefix) VALUES
  ('DICT Job Fair Tuguegarao', 'Cagayan State University - August 8 (Thursday)', 'Cagayan24'),
  ('DICT Job Fair Cauayan', 'Isabela State University - August 9 (Friday)', 'Isabela24');

INSERT INTO Timeslots (timestart, timeend, event_id) VALUES
  ('2024-08-08 13:00:00', '2024-08-08 13:30:00', 1),
  ('2024-08-08 13:30:00', '2024-08-08 14:00:00', 1),
  ('2024-08-08 14:00:00', '2024-08-08 14:30:00', 1),
  ('2024-08-08 14:30:00', '2024-08-08 15:00:00', 1),
  ('2024-08-08 15:00:00', '2024-08-08 15:30:00', 1),
  ('2024-08-08 15:30:00', '2024-08-08 16:00:00', 1),
  ('2024-08-08 16:00:00', '2024-08-08 16:30:00', 1),
  ('2024-08-09 09:30:00', '2024-08-09 10:00:00', 2),
  ('2024-08-09 10:00:00', '2024-08-09 10:30:00', 2),
  ('2024-08-09 10:30:00', '2024-08-09 11:00:00', 2),
  ('2024-08-09 11:00:00', '2024-08-09 11:30:00', 2),
  ('2024-08-09 11:30:00', '2024-08-09 12:00:00', 2),
  ('2024-08-09 12:00:00', '2024-08-09 12:30:00', 2),
  ('2024-08-09 12:30:00', '2024-08-09 13:00:00', 2);

INSERT INTO Booths (topic, presentor, event_id, email, logo, password) VALUES
  ('Teleperformance', 'Teleperformance', 1, "teleperformance1", "assets/logo/teleperformance.png", "$2y$10$VZRa706y4ZrGf2/8gPtm4On2T3sP1GV/kC49gaZ9Br1rYKJedl5I6"),
  ('iRhythm', 'iRhythm', 1, "irhythm1", "assets/logo/iRhythm.png", "$2y$10$EdTk15AFJBztrY3mCvPr2udJ8ptay9vt9jxKeXQ5YJWM8vhYt.CNG"),
  ('Everise', 'Everise', 1, "everise1", "assets/logo/everise.png", "$2y$10$8ABfEv347GuyJmAfsapsxOyqua36Bn8.HmhJVFPS1SPL0TRtDZDxa"),
  ('Alorica', 'Alorica', 1, "alorica1", "assets/logo/alorica.png", "$2y$10$BIZQ31T5uh.KB7BoTGHno.75eGlJFZfauCuK7GI2ABULa0JMnktIy"),
  ('Accenture', 'Accenture', 1, "accenture1", "assets/logo/accenture.png", "$2y$10$Cb3gQhZJoaaIe1uOko0hWuLOOOtGUw9OOZjah/RyO8h6e8tV8rDri"),
  ('Elite Virtual Employment Solutions', 'Elite Virtual Employment Solutions', 1, "eves1", "assets/logo/eves.png", "$2y$10$Asat.QOp9MkktqGANZ0vxOoDvWFVX2jwuLGpbwUSCTtg9rPWU4Sdi"),
  ('Phoenix Virtual Solutions', 'Phoenix Virtual Solutions', 1, "phoenix1", "assets/logo/phoenix.png", "$2y$10$qxD.0DbS/b2fRRI9drmlzeUU.WZ.5ihig6YEgPCzlQZkh20udp9tm"),
  ('Teleperformance', 'Teleperformance', 2, "teleperformance2", "assets/logo/teleperformance.png", "$2y$10$VZRa706y4ZrGf2/8gPtm4On2T3sP1GV/kC49gaZ9Br1rYKJedl5I6"),
  ('iRhythm', 'iRhythm', 2, "irhythm2", "assets/logo/iRhythm.png", "$2y$10$EdTk15AFJBztrY3mCvPr2udJ8ptay9vt9jxKeXQ5YJWM8vhYt.CNG"),
  ('Everise', 'Everise', 2, "everise2", "assets/logo/everise.png", "$2y$10$8ABfEv347GuyJmAfsapsxOyqua36Bn8.HmhJVFPS1SPL0TRtDZDxa"),
  ('Alorica', 'Alorica', 2, "alorica2", "assets/logo/alorica.png", "$2y$10$BIZQ31T5uh.KB7BoTGHno.75eGlJFZfauCuK7GI2ABULa0JMnktIy"),
  ('Accenture', 'Accenture', 2, "accenture2", "assets/logo/accenture.png", "$2y$10$Cb3gQhZJoaaIe1uOko0hWuLOOOtGUw9OOZjah/RyO8h6e8tV8rDri"),
  ('Elite Virtual Employment Solutions', 'Elite Virtual Employment Solutions', 2, "eves2", "assets/logo/eves.png", "$2y$10$Asat.QOp9MkktqGANZ0vxOoDvWFVX2jwuLGpbwUSCTtg9rPWU4Sdi"),
  ('Phoenix Virtual Solutions', 'Phoenix Virtual Solutions', 2, "phoenix2", "assets/logo/phoenix.png", "$2y$10$qxD.0DbS/b2fRRI9drmlzeUU.WZ.5ihig6YEgPCzlQZkh20udp9tm");

