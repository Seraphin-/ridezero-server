----
-- phpLiteAdmin database dump (http://www.phpliteadmin.org/)
-- phpLiteAdmin version: 1.9.7.1
-- Exported: 11:27am on May 28, 2019 (UTC)
----
BEGIN TRANSACTION;

----
-- Table structure for users_supports
----
CREATE TABLE 'users_supports' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'playerId' INTEGER, 'supportId' INTEGER, 'grade' INTEGER, 'level' INTEGER, 'quantity' INTEGER, 'nextRequireQuantity' INTEGER);
COMMIT;
