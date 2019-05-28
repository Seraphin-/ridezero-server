----
-- phpLiteAdmin database dump (http://www.phpliteadmin.org/)
-- phpLiteAdmin version: 1.9.7.1
-- Exported: 11:26am on May 28, 2019 (UTC)
----
BEGIN TRANSACTION;

----
-- Table structure for users_episodes
----
CREATE TABLE 'users_episodes' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'playerId' INTEGER, 'charCode' TEXT, 'clearStageNo' INTEGER);
COMMIT;
