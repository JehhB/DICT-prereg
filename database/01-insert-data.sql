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

-- Password is 'adminpassword'
INSERT INTO Booths (topic, presentor, event_id, email, password) VALUES
  ('Cybersecurity Trends', 'Cagayan Tech Solutions', 1, "admin+1@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Cloud Computing Services', 'Northern Luzon IT Corp', 1, "admin+2@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('AI in Agriculture', 'Cagayan Valley Innovations', 1, "admin+3@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('IoT for Smart Cities', 'TechnoTuguegarao', 1, "admin+4@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Big Data Analytics', 'DataSmart Cagayan', 1, "admin+5@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('5G Technology', 'ConnectCagayan', 1, "admin+6@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Blockchain Applications', 'CryptoValley Solutions', 1, "admin+7@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Mobile App Development', 'AppGenius Tuguegarao', 1, "admin+8@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('E-commerce Platforms', 'Digital Marketplace Cagayan', 1, "admin+9@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Virtual Reality in Education', 'EduTech Cagayan', 1, "admin+10@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Machine Learning for Business', 'Isabela AI Innovations', 2, "admin+11@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Digital Marketing Strategies', 'WebSavvy Cauayan', 2, "admin+12@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Robotic Process Automation', 'AutomateIsabela', 2, "admin+13@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Augmented Reality in Retail', 'FutureShop Technologies', 2, "admin+14@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Cybersecurity for SMEs', 'SecureNet Isabela', 2, "admin+15@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Green IT Solutions', 'EcoTech Cauayan', 2, "admin+16@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Data Privacy and Protection', 'PrivacyGuard Solutions', 2, "admin+17@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Smart Agriculture Tech', 'AgriTech Isabela', 2, "admin+18@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('Web Development Frameworks', 'CodeMasters Cauayan', 2, "admin+19@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy"),
  ('IT Infrastructure Management', 'NetPro Isabela', 2, "admin+20@gmail.com", "$2y$10$2/NP5Wwd4wasrRqkDSm2guS8Af8e.1kc/.6fOwR.ciyrY/D4oGquy");
