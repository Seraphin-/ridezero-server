----
-- phpLiteAdmin database dump (http://www.phpliteadmin.org/)
-- phpLiteAdmin version: 1.9.7.1
-- Exported: 11:26am on May 28, 2019 (UTC)
----
BEGIN TRANSACTION;

----
-- Table structure for users_flags
----
CREATE TABLE 'users_flags' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'playerId' INTEGER, 'flagKey' TEXT, 'value' INTEGER);
COMMIT;
