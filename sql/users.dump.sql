----
-- phpLiteAdmin database dump (http://www.phpliteadmin.org/)
-- phpLiteAdmin version: 1.9.7.1
-- Exported: 11:25am on May 28, 2019 (UTC)
----
BEGIN TRANSACTION;

----
-- Table structure for users
----
CREATE TABLE 'users' ('playerId' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'platform' TEXT, 'loginId' TEXT, 'name' TEXT, 'clearStoryNo' INTEGER, 'isRating' INTEGER, 'language' INTEGER, 'musicByGoldCount' INTEGER, 'nameChangeCount' INTEGER, 'openStoryNo' INTEGER, 'supportByGoldCount' INTEGER, 'tutorialNo' INTEGER, 'webuiSecret' TEXT);
COMMIT;
