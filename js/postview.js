$(function () {

    function changeText() { // textarea 크기자동조절
        $(this).height(1).height( $(this).prop('scrollHeight')+12 );
    }
    $(".text").on("keydown keyup", changeText);
    $(".text").keyup();

    $(".modal-btn").click(function () { // 수정, 삭제버튼 클릭시

        switch ($(this).attr('id')) {
            case 'delBtn' : // 삭제버튼이라면
                $("#modalform").attr("action", "./deleteprogress.php");
                break;
            case 'updateBtn' : // 수정버튼이라면
                $("#modalform").attr("action", "./postupdate.php");
                break;
        }

    });

});