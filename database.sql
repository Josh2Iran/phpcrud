CREATE DATABASE IF NOT EXISTS phpcrud;
USE phpcrud;
CREATE TABLE IF NOT EXISTS tblusers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT IGNORE INTO tblusers (name, email) VALUES
 ('Josh', 'josh@example.com'),
 ('Amina', 'amina@example.com');
