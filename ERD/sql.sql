CREATE USER 'boardadmin'@'localhost' IDENTIFIED BY 'board1234';

CREATE DATABASE 'board';

CREATE TABLE POST
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

ALTER TABLE POST COMMENT '게시글';