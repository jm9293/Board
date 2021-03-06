
-- DDL 시작
CREATE USER 'boardadmin'@'localhost' IDENTIFIED BY 'board1234';

CREATE DATABASE board;

CREATE TABLE board.POST -- 게시판 테이블
(
    `NUM`        INT             NOT NULL    AUTO_INCREMENT COMMENT '번호', 
    `USERNAME`   VARCHAR(25)    NOT NULL        COMMENT '작성자',
    `PASSWORD`   VARCHAR(10)     NOT NULL        COMMENT '비밀번호', 
    `TITLE`      VARCHAR(20)     NOT NULL        COMMENT '제목', 
    `CONTENT`    TEXT(500)       NOT NULL        COMMENT '내용', 
    `VIEWCOUNT`  INT             NOT NULL        COMMENT '조회수', 
    `WRDATE`     DATETIME        NOT NULL        COMMENT '작성일', 
    `UWDATE`     DATETIME        NULL        COMMENT '수정일', 
    PRIMARY KEY (NUM)
);

ALTER TABLE board.POST COMMENT '게시글';

CREATE TABLE board.ADMIN -- 관리자 계정 테이블
(
    `NUM`       INT            NULL        AUTO_INCREMENT COMMENT '번호',
    `ID`        VARCHAR(10)    NULL        COMMENT '아이디',
    `PASSWORD`  VARCHAR(10)    NULL        COMMENT '비빌번호',
    PRIMARY KEY (NUM)
);

ALTER TABLE board.ADMIN COMMENT '관리자계정';

ALTER TABLE board.ADMIN
    ADD CONSTRAINT UC_ID UNIQUE (ID);



-- DCL
GRANT INSERT , UPDATE , DELETE  , SELECT ON board.* TO boardadmin@localhost; -- 권한 부여
flush privileges;

-- DML 시작

use board;
INSERT INTO admin (ID,PASSWORD) VALUES ('admin','1234' ); -- 기본 관리자 계정 생성

-- 테스트 DML 50개
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 01', 'PASSWORD01', 'TITLE 01', 'CONTENT 01', 01, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 02', 'PASSWORD02', 'TITLE 02', 'CONTENT 02', 02, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 03', 'PASSWORD03', 'TITLE 03', 'CONTENT 03', 03, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 04', 'PASSWORD04', 'TITLE 04', 'CONTENT 04', 04, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 05', 'PASSWORD05', 'TITLE 05', 'CONTENT 05', 05, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 06', 'PASSWORD06', 'TITLE 06', 'CONTENT 06', 06, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 07', 'PASSWORD07', 'TITLE 07', 'CONTENT 07', 07, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 08', 'PASSWORD08', 'TITLE 08', 'CONTENT 08', 08, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 09', 'PASSWORD09', 'TITLE 09', 'CONTENT 09', 09, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 10', 'PASSWORD10', 'TITLE 10', 'CONTENT 10', 10, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 11', 'PASSWORD11', 'TITLE 11', 'CONTENT 11', 11, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 12', 'PASSWORD12', 'TITLE 12', 'CONTENT 12', 12, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 13', 'PASSWORD13', 'TITLE 13', 'CONTENT 13', 13, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 14', 'PASSWORD14', 'TITLE 14', 'CONTENT 14', 14, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 15', 'PASSWORD15', 'TITLE 15', 'CONTENT 15', 15, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 16', 'PASSWORD16', 'TITLE 16', 'CONTENT 16', 16, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 17', 'PASSWORD17', 'TITLE 17', 'CONTENT 17', 17, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 18', 'PASSWORD18', 'TITLE 18', 'CONTENT 18', 18, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 19', 'PASSWORD19', 'TITLE 19', 'CONTENT 19', 19, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 20', 'PASSWORD20', 'TITLE 20', 'CONTENT 20', 20, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 21', 'PASSWORD21', 'TITLE 21', 'CONTENT 21', 21, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 22', 'PASSWORD22', 'TITLE 22', 'CONTENT 22', 22, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 23', 'PASSWORD23', 'TITLE 23', 'CONTENT 23', 23, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 24', 'PASSWORD24', 'TITLE 24', 'CONTENT 24', 24, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 25', 'PASSWORD25', 'TITLE 25', 'CONTENT 25', 25, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 26', 'PASSWORD26', 'TITLE 26', 'CONTENT 26', 26, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 27', 'PASSWORD27', 'TITLE 27', 'CONTENT 27', 27, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 28', 'PASSWORD28', 'TITLE 28', 'CONTENT 28', 28, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 29', 'PASSWORD29', 'TITLE 29', 'CONTENT 29', 29, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 30', 'PASSWORD30', 'TITLE 30', 'CONTENT 30', 30, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 31', 'PASSWORD31', 'TITLE 31', 'CONTENT 31', 31, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 32', 'PASSWORD32', 'TITLE 32', 'CONTENT 32', 32, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 33', 'PASSWORD33', 'TITLE 33', 'CONTENT 33', 33, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 34', 'PASSWORD34', 'TITLE 34', 'CONTENT 34', 34, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 35', 'PASSWORD35', 'TITLE 35', 'CONTENT 35', 35, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 36', 'PASSWORD36', 'TITLE 36', 'CONTENT 36', 36, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 37', 'PASSWORD37', 'TITLE 37', 'CONTENT 37', 37, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 38', 'PASSWORD38', 'TITLE 38', 'CONTENT 38', 38, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 39', 'PASSWORD39', 'TITLE 39', 'CONTENT 39', 39, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 40', 'PASSWORD40', 'TITLE 40', 'CONTENT 40', 40, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 41', 'PASSWORD41', 'TITLE 41', 'CONTENT 41', 41, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 42', 'PASSWORD42', 'TITLE 42', 'CONTENT 42', 42, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 43', 'PASSWORD43', 'TITLE 43', 'CONTENT 43', 43, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 44', 'PASSWORD44', 'TITLE 44', 'CONTENT 44', 44, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 45', 'PASSWORD45', 'TITLE 45', 'CONTENT 45', 45, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 46', 'PASSWORD46', 'TITLE 46', 'CONTENT 46', 46, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 47', 'PASSWORD47', 'TITLE 47', 'CONTENT 47', 47, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 48', 'PASSWORD48', 'TITLE 48', 'CONTENT 48', 48, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 49', 'PASSWORD49', 'TITLE 49', 'CONTENT 49', 49, NOW(), NOW());
INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE, UWDATE) VALUES ('USERNAME 50', 'PASSWORD50', 'TITLE 50', 'CONTENT 50', 50, NOW(), NOW());

-- 삭제시 사용
-- DROP USER 'boardaamin'@'localhost';
-- DROP DATABASE board ;