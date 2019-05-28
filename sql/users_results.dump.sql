----
-- phpLiteAdmin database dump (http://www.phpliteadmin.org/)
-- phpLiteAdmin version: 1.9.7.1
-- Exported: 11:26am on May 28, 2019 (UTC)
----
BEGIN TRANSACTION;

----
-- Table structure for users_results
----
CREATE TABLE 'users_results' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'playerId' INTEGER, 'musicNo' INTEGER,'patternNo' INTEGER, 'score' INTEGER, 'content' TEXT);
COMMIT;
