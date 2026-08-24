INSERT INTO sources (name, url, is_official)
VALUES ('Demo MrKarir AI', 'https://mrkarirai.web.id', 1)
ON CONFLICT(name) DO NOTHING;

INSERT INTO jobs (
    source_id, title, company, location, is_remote, employment_type,
    description, requirements, apply_url, published_at, expires_at
)
SELECT id, 'Customer Service Online', 'Perusahaan Demo Indonesia', 'Palembang', 1, 'Full-time',
       'Melayani pertanyaan pelanggan melalui chat dan membantu menyelesaikan kendala dasar.',
       'Komunikatif, teliti, dan mampu menggunakan perangkat Android atau komputer.',
       'https://example.com/jobs/customer-service-online', datetime('now'), datetime('now', '+30 days')
FROM sources WHERE name = 'Demo MrKarir AI'
ON CONFLICT(apply_url) DO NOTHING;

INSERT INTO jobs (
    source_id, title, company, location, is_remote, employment_type,
    description, requirements, apply_url, published_at, expires_at
)
SELECT id, 'Junior Web Developer', 'Startup Demo Nusantara', 'Jakarta', 0, 'Internship',
       'Membantu pengembangan halaman web, API sederhana, dan dokumentasi teknis.',
       'Memahami dasar HTML, CSS, JavaScript, PHP, dan Git.',
       'https://example.com/jobs/junior-web-developer', datetime('now'), datetime('now', '+45 days')
FROM sources WHERE name = 'Demo MrKarir AI'
ON CONFLICT(apply_url) DO NOTHING;

INSERT INTO jobs (
    source_id, title, company, location, is_remote, employment_type,
    description, requirements, apply_url, published_at, expires_at
)
SELECT id, 'Data Entry Remote', 'Bisnis Demo Digital', 'Remote', 1, 'Part-time',
       'Memasukkan dan memeriksa data dengan mengikuti format yang telah ditentukan.',
       'Teliti, konsisten, dan memahami spreadsheet dasar.',
       'https://example.com/jobs/data-entry-remote', datetime('now'), datetime('now', '+20 days')
FROM sources WHERE name = 'Demo MrKarir AI'
ON CONFLICT(apply_url) DO NOTHING;
