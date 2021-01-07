function  validchk(){ // 입력값 유효한지 확인후 버튼활성화
    let chk = $("#title").hasClass("is-valid")&&$("#text").hasClass("is-valid");
    if(chk){
        $("#updateBtn").removeAttr("disabled");
    }else{
        $("#updateBtn").attr("disabled","");
    }
}

function changeText() { // textarea 크기자동조절
    $(this).height(1).height( $(this).prop('scrollHeight')+12 );
}

$(function () {

    $("#text").on("keydown keyup", changeText);
    $("#text").keyup();

    $("#title").keyup(function(){ // 제목이 입력되었는지 확인
        let value =  $("#title").val();
        if(value.trim() !== ""){
            $("#title").addClass("is-valid");
            $("#title").removeClass("is-invalid");
        }else{
            $("#title").addClass("is-invalid");
            $("#title").removeClass("is-valid");
        }
        validchk();
    })

    $("#text").keyup(function(){ // 제목이 입력되었는지 확인
        let value =  $("#text").val();
        if(value.trim() !== ""){
            $("#text").addClass("is-valid");
            $("#text").removeClass("is-invalid");
        }else{
            $("#text").addClass("is-invalid");
            $("#text").removeClass("is-valid");
        }
        validchk();
    })
    $("#title").keyup(); // 검증상태 확인
    $("#text").keyup();
    validchk();


});