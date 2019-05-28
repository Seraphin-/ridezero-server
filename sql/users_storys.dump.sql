----
-- phpLiteAdmin database dump (http://www.phpliteadmin.org/)
-- phpLiteAdmin version: 1.9.7.1
-- Exported: 11:27am on May 28, 2019 (UTC)
----
BEGIN TRANSACTION;

----
-- Table structure for users_storys
----
CREATE TABLE 'users_storys' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'playerId' INTEGER, 'groupNo' INTEGER, 'storyNo' INTEGER,'isBlock' INTEGER,'isClear' INTEGER);
COMMIT;
