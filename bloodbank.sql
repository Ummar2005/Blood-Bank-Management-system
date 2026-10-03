-- ============================================
-- SAMPLE DATA FOR BLOOD BANK PROJECT
-- GitHub-safe dummy data
-- Demo password for sample accounts: Demo@123
-- ============================================


-- --------------------------------------------
-- HOSPITALS
-- --------------------------------------------

INSERT INTO hospitals
(hospital_id, hospital_name, email, password, latitude, longitude, phone, address, city, bg)
VALUES
(101, 'City Care Hospital', 'citycare@example.com',
 '$2y$12$EXctYIUU4zIIPWIulsRkEO/gRhdKnnK9.n/1tEECFoA.lSvZux5GO',
 12.97160000, 77.59460000, '9000000001',
 'MG Road', 'Bengaluru', 'A+'),

(102, 'Life Line Hospital', 'lifeline@example.com',
 '$2y$12$EXctYIUU4zIIPWIulsRkEO/gRhdKnnK9.n/1tEECFoA.lSvZux5GO',
 15.31730000, 75.71390000, '9000000002',
 'Main Road', 'Hubballi', 'B+');


-- --------------------------------------------
-- RECEIVERS
-- --------------------------------------------

INSERT INTO receivers
(id, name, email, password, phone, bg, city)
VALUES
(101, 'Demo Receiver One', 'receiver1@example.com',
 '$2y$12$EXctYIUU4zIIPWIulsRkEO/gRhdKnnK9.n/1tEECFoA.lSvZux5GO',
 '9000000011', 'A+', 'Bengaluru'),

(102, 'Demo Receiver Two', 'receiver2@example.com',
 '$2y$12$EXctYIUU4zIIPWIulsRkEO/gRhdKnnK9.n/1tEECFoA.lSvZux5GO',
 '9000000012', 'B+', 'Hubballi');


-- --------------------------------------------
-- BLOOD REQUESTS
-- --------------------------------------------

INSERT INTO bloodrequest
(reqid, hid, rid, bg, status)
VALUES
(101, 101, 101, 'A+', 'Pending'),

(102, 102, 102, 'B+', 'Accepted'),

(103, 101, 102, 'O+', 'Rejected');