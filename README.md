## Board
PHP 게시판 (학습용)

회원가입 없이 누구나 사용할수 있는 익명 게시판입니다.
## 기능목록
1. 게시판 리스트

   작성된 게시글들을 보고 검색할수 있습니다.

2. 게시글 관리

   게시글 작성하고 게시글 비밀번호를 입력하고 수정 , 삭제등을 할수 있습니다.

3. 관리자 계정

    관리자 계정으로 로그인시 모든글을 삭제, 수정 할수 있습니다.

## 개발정보
- 언어 : PHP 7.2.34 , JavaScript(ES5) , HTML5 , CSS3 , MariaDB SQL
- WEBSERVER : Apache 2.4.46
- DBMS : MariaDB 10.4.14
- UI FrameWork : Bootstrap 4.3.1
- Lib : jQurey3.3.1

## ERD
<img src="https://user-images.githubusercontent.com/67568714/103968433-34abe180-51a7-11eb-9569-052553925958.png" width="90%"></img>

## 페이지설명

/list.php : 게시판 (메인페이지)

/postview.php :  게시글 열람 (num : 파라메타필수)

/postupdate.php : 게시글 수정페이지 (num : 파라메타필수)

/postwrite.php : 게시글 작성페이지

## 인스톨
1. XAMPP 다운로드 후 설치하세요.

2. XAMPP CONTROLPANEL을 이용해 Apache , MariaDB 가동하세요.

3. MariaDB의 sql/sql.sql 파일에 있는 sql 스크립트 실행하여 계정, 데이터베이스, 테이블, 기본정보 생성하세요

4. xampp/htdocs 에 board 폴더를 이동후 localhost/board/list.php 접속하세요.

5. 기본 관리자 계정은 admin/1234 로 설정되어있습니다.


