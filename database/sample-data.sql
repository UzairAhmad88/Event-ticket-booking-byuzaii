-- ============================================================
-- SAMPLE DATA — Event Ticket Booking System
-- Run AFTER event_booking.sql
-- ============================================================

USE event_booking;

-- ------------------------------------------------------------
-- DEFAULT ADMIN ACCOUNT
-- Email    : admin@admin.com
-- Password : password   (bcrypt hash below)
-- ------------------------------------------------------------
INSERT INTO users (name, email, phone, password, role) VALUES
(
    'Admin',
    'admin@admin.com',
    '03001234567',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'admin'
);

-- ------------------------------------------------------------
-- SAMPLE REGULAR USER
-- Email    : user@user.com
-- Password : password
-- ------------------------------------------------------------
INSERT INTO users (name, email, phone, password, role) VALUES
(
    'Test User',
    'user@user.com',
    '03009876543',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'user'
);

-- ------------------------------------------------------------
-- SAMPLE EVENTS
-- ------------------------------------------------------------
INSERT INTO events (title, description, event_date, event_time, venue, total_seats, available_seats, price, image) VALUES
(
    'Music Concert 2026',
    'An unforgettable live music experience featuring top artists.',
    '2026-06-15',
    '19:00:00',
    'Karachi Expo Centre',
    40,
    40,
    1500.00,
    'default-event.jpg'
),
(
    'Tech Summit',
    'Annual technology conference with industry leaders and workshops.',
    '2026-07-20',
    '09:00:00',
    'Lahore Convention Centre',
    40,
    40,
    2500.00,
    'default-event.jpg'
),
(
    'Football Final',
    'Championship final match — the biggest game of the season.',
    '2026-08-10',
    '17:00:00',
    'National Stadium Karachi',
    40,
    40,
    500.00,
    'default-event.jpg'
);

-- ------------------------------------------------------------
-- SEATS for Event 1 (id=1) — A1 to A40
-- ------------------------------------------------------------
INSERT INTO seats (event_id, seat_number)
SELECT 1, CONCAT('A', n) FROM (
    SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
    UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10
    UNION SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14 UNION SELECT 15
    UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19 UNION SELECT 20
    UNION SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24 UNION SELECT 25
    UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29 UNION SELECT 30
    UNION SELECT 31 UNION SELECT 32 UNION SELECT 33 UNION SELECT 34 UNION SELECT 35
    UNION SELECT 36 UNION SELECT 37 UNION SELECT 38 UNION SELECT 39 UNION SELECT 40
) AS numbers;

-- SEATS for Event 2 (id=2)
INSERT INTO seats (event_id, seat_number)
SELECT 2, CONCAT('A', n) FROM (
    SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
    UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10
    UNION SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14 UNION SELECT 15
    UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19 UNION SELECT 20
    UNION SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24 UNION SELECT 25
    UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29 UNION SELECT 30
    UNION SELECT 31 UNION SELECT 32 UNION SELECT 33 UNION SELECT 34 UNION SELECT 35
    UNION SELECT 36 UNION SELECT 37 UNION SELECT 38 UNION SELECT 39 UNION SELECT 40
) AS numbers;

-- SEATS for Event 3 (id=3)
INSERT INTO seats (event_id, seat_number)
SELECT 3, CONCAT('A', n) FROM (
    SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
    UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10
    UNION SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14 UNION SELECT 15
    UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19 UNION SELECT 20
    UNION SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24 UNION SELECT 25
    UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29 UNION SELECT 30
    UNION SELECT 31 UNION SELECT 32 UNION SELECT 33 UNION SELECT 34 UNION SELECT 35
    UNION SELECT 36 UNION SELECT 37 UNION SELECT 38 UNION SELECT 39 UNION SELECT 40
) AS numbers;