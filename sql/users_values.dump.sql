----
-- phpLiteAdmin database dump (http://www.phpliteadmin.org/)
-- phpLiteAdmin version: 1.9.7.1
-- Exported: 11:28am on May 28, 2019 (UTC)
----
BEGIN TRANSACTION;

----
-- Table structure for users_values
----
CREATE TABLE 'users_values' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'playerId' INTEGER, 'valueKey' TEXT, 'intValue' INTEGER, 'stringValue' TEXT);
COMMIT;
