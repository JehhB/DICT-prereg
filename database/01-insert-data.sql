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
  ('Cybersecurity Trends', 'Cagayan Tech Solutions', 1),
  ('Cloud Computing Services', 'Northern Luzon IT Corp', 1),
  ('AI in Agriculture', 'Cagayan Valley Innovations', 1),
  ('IoT for Smart Cities', 'TechnoTuguegarao', 1),
  ('Big Data Analytics', 'DataSmart Cagayan', 1),
  ('5G Technology', 'ConnectCagayan', 1),
  ('Blockchain Applications', 'CryptoValley Solutions', 1),
  ('Mobile App Development', 'AppGenius Tuguegarao', 1),
  ('E-commerce Platforms', 'Digital Marketplace Cagayan', 1),
  ('Virtual Reality in Education', 'EduTech Cagayan', 1),
  ('Machine Learning for Business', 'Isabela AI Innovations', 2),
  ('Digital Marketing Strategies', 'WebSavvy Cauayan', 2),
  ('Robotic Process Automation', 'AutomateIsabela', 2),
  ('Augmented Reality in Retail', 'FutureShop Technologies', 2),
  ('Cybersecurity for SMEs', 'SecureNet Isabela', 2),
  ('Green IT Solutions', 'EcoTech Cauayan', 2),
  ('Data Privacy and Protection', 'PrivacyGuard Solutions', 2),
  ('Smart Agriculture Tech', 'AgriTech Isabela', 2),
  ('Web Development Frameworks', 'CodeMasters Cauayan', 2),
  ('IT Infrastructure Management', 'NetPro Isabela', 2);
