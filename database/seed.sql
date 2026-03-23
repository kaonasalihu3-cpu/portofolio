USE kaona_salihu_db;

INSERT INTO roles (id, role_name) VALUES
  (1, 'admin'),
  (2, 'user')
ON DUPLICATE KEY UPDATE role_name = VALUES(role_name);

-- Password for both seeded users: password
INSERT INTO users (id, full_name, email, password, role_id) VALUES
  (1, 'Kaona Salihu Admin', 'admin@kaona.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/.R0WmQz4Q5t5.', 1),
  (2, 'Kaona Salihu User', 'user@kaona.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/.R0WmQz4Q5t5.', 2)
ON DUPLICATE KEY UPDATE full_name = VALUES(full_name), role_id = VALUES(role_id);

INSERT INTO site_content (page_key, section_key, title, body, image, updated_by) VALUES
  ('home', 'hero', 'KAONA SALIHU', 'Creative student professional portfolio focused on web development, digital content, and practical full-stack systems.', 'assets/images/kaona-profile.jpg', 1),
  ('home', 'about_preview', 'About Kaona Salihu', 'Kaona Salihu builds clean, responsive, and database-driven websites with strong focus on usability and academic quality.', 'assets/images/about-preview.svg', 1),
  ('home', 'cta', 'Start a Project', 'Need a modern website, portfolio, or content dashboard? Get in touch and let us build your idea together.', NULL, 1),
  ('about', 'intro', 'Professional Profile', 'Kaona Salihu is a student-focused digital brand showcasing portfolio work, updates, and product concepts built with HTML, CSS, JavaScript, PHP, and MySQL.', 'assets/images/kaona-profile.jpg', 1),
  ('about', 'mission', 'Mission', 'Deliver practical and polished digital solutions that combine design clarity with backend reliability.', NULL, 1),
  ('about', 'vision', 'Vision', 'Grow into a trusted full-stack professional building scalable products for education and small businesses.', NULL, 1)
ON DUPLICATE KEY UPDATE
  title = VALUES(title),
  body = VALUES(body),
  image = VALUES(image),
  updated_by = VALUES(updated_by);

INSERT INTO products (title, slug, short_description, body, image, pdf_file, created_by, updated_by) VALUES
  ('Student Finance Tracker', 'student-finance-tracker', 'A clean dashboard for tracking student expenses and budgets.', 'The Student Finance Tracker helps students monitor spending categories, monthly trends, and financial discipline goals through a simple and responsive interface.', 'assets/images/product-1.svg', NULL, 1, 1),
  ('Campus Event Portal', 'campus-event-portal', 'A platform for discovering and managing campus events.', 'Campus Event Portal centralizes student activities, deadline reminders, and event detail pages. It improves participation and communication for university communities.', 'assets/images/product-2.svg', NULL, 1, 1),
  ('Digital CV Builder', 'digital-cv-builder', 'A user-friendly resume builder for students and graduates.', 'Digital CV Builder allows users to input personal and academic information and generate an organized portfolio-style CV layout suitable for internship and job applications.', 'assets/images/product-3.svg', NULL, 1, 1),
  ('Academic Notes Hub', 'academic-notes-hub', 'Structured library interface for lecture note access.', 'Academic Notes Hub provides a categorized interface for note sharing and download management with secure content structure and scalable backend support.', 'assets/images/product-4.svg', NULL, 1, 1)
ON DUPLICATE KEY UPDATE
  short_description = VALUES(short_description),
  body = VALUES(body),
  image = VALUES(image),
  pdf_file = VALUES(pdf_file),
  updated_by = VALUES(updated_by);

INSERT INTO news (title, slug, body, image, pdf_file, created_by, updated_by) VALUES
  ('New Portfolio Version Released', 'new-portfolio-version-released', 'A redesigned version of the Kaona Salihu website is now available with a cleaner interface, improved responsiveness, and stronger content management support.', 'assets/images/news-1.svg', NULL, 1, 1),
  ('Contact Workflow Improved', 'contact-workflow-improved', 'The contact form now stores submissions directly in the database and allows admin review inside dashboard message management.', 'assets/images/news-2.svg', NULL, 1, 1),
  ('Admin Dashboard Extended', 'admin-dashboard-extended', 'The dashboard now supports products, news, and site content CRUD with role-based protection and secure file uploads.', 'assets/images/news-3.svg', NULL, 1, 1)
ON DUPLICATE KEY UPDATE
  body = VALUES(body),
  image = VALUES(image),
  pdf_file = VALUES(pdf_file),
  updated_by = VALUES(updated_by);



