function  validchk(){ // 입력값 유효한지 확인후 버튼활성화
    let chk = $("#title").hasClass("is-valid")&&$("#writepassword").hasClass("is-valid")
        &&$("#writepasswordChk").hasClass("is-valid")&&$("#text").hasClass("is-valid");
    if(chk){
        $("#writeBtn").removeAttr("disabled");
    }else{
        $("#writeBtn").attr("disabled","");
    }
}

function changeText() { // textarea 크기자동조절
    $(this).height(1).height( $(this).prop('scrollHeight')+12 );
}

$(function () {

    $(".text").on("keydown keyup", changeText);
    $(".text").keyup();

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

    $("#writepassword").keyup(function(){ // 패스워드가 입력되었는지 확인
        let value =  $("#writepassword").val();
        if(value.trim() !== ""){
            $("#writepassword").addClass("is-valid");
            $("#writepassword").removeClass("is-invalid");
        }else{
            $("#writepassword").addClass("is-invalid");
            $("#writepassword").removeClass("is-valid");
        }
        validchk();
    })

    $("#writepasswordChk").keyup(function(){ // 패스워드확인이 패스워드와 같은지 확인
        let value =  $("#writepasswordChk").val();
        if(value !== $("#writepassword").val()){
            $("#writepasswordChk").addClass("is-invalid");
            $("#writepasswordChk").removeClass("is-valid");
        }else{
            $("#writepasswordChk").addClass("is-valid");
            $("#writepasswordChk").removeClass("is-invalid");
        }
        validchk();
    })

    $("#text").keyup(function(){ // 패스워드확인이 패스워드와 같은지 확인
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

});