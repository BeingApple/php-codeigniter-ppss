<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">관리자 / 필자 등록</h1>
</div>

<form id="dataForm" method="POST" action="<?php echo ($adminData->ADMIN_GRADE == "S")?"/admin/adminWriteProc":"/admin/myProfileProc";?>" enctype="multipart/form-data"> 
    <?php
        if($userData->ADMIN_SEQ > 0){
    ?>
            <input type="hidden" name="adminSeq" value="<?php echo $userData->ADMIN_SEQ; ?>" />
            <input type="hidden" name="mode" value="modify" />
    <?php
        }else{
    ?>
            <input type="hidden" name="mode" value="write" />
    <?php
        }
    ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" >썸네일</label>
        <div class="col-sm-10">
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="customFile" id="customFile">
                <label class="custom-file-label" for="customFile">파일을 선택하세요</label>
                <small id="fileHelpBlock" class="form-text text-muted">
                    <?php
                        if($userData->ADMIN_FILE_NAME != NULL){
                    ?>
                            <a href="/uploads/ppss/<?php echo $userData->ADMIN_FILE_NAME; ?>" target="_blank"><?php echo $userData->ADMIN_FILE_ORG; ?></a>
                    <?php
                        }else{
                    ?>
                            이미지만 적용 됩니다. 이미지는 70x70 사이즈로 조정됩니다.
                    <?php
                        }
                    ?>
                </small>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="adminPassword" class="col-sm-2 col-form-label" >이름</label>
        <div class="col-sm-10">
            <input type="text" id="adminName" name="adminName" value="<?php echo $userData->ADMIN_NAME; ?>" class="form-control" placeholder="이름" aria-label="이름">
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-group row">
        <label for="adminId" class="col-sm-2 col-form-label" >아이디</label>
        <div class="col-sm-10 input-group">
            <input type="text" id="adminId" name="adminId" value="<?php echo $userData->ADMIN_ID; ?>" class="form-control" placeholder="아이디" aria-label="아이디" aria-describedby="btn-dup">
            <?php
                if(!is_null($userData->ADMIN_ID)){
            ?>
                    <input type="hidden" id="dupCheck" class="form-control" value="Y" />
                    <input type="hidden" id="idCheck" class="form-control" value="<?php echo $userData->ADMIN_ID; ?>" />
            <?php
                }else{
            ?>
                    <input type="hidden" id="dupCheck" class="form-control" value="N" />
            <?php
                }
            ?>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="btn-dup" <?php echo (!is_null($userData->ADMIN_ID))?"disabled":""; ?> >중복확인</button>
            </div>
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-group row">
        <label for="adminPassword" class="col-sm-2 col-form-label" >비밀번호</label>
        <div class="col-sm-10">
            <input type="password" id="adminPassword" name="adminPassword" class="form-control" placeholder="비밀번호" aria-label="비밀번호">
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="form-group row">
        <label for="adminPasswordChk" class="col-sm-2 col-form-label" >비밀번호 확인</label>
        <div class="col-sm-10">
            <input type="password" id="adminPasswordChk" class="form-control" placeholder="비밀번호 확인" aria-label="비밀번호 확인">
        </div>
    </div>

    <?php if($adminData->ADMIN_GRADE == "S"){ ?>

        <fieldset  class="form-group">
            <div class="row">
                <legend class="col-form-label col-sm-2 pt-0">사용 여부</legend>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="useYn" id="useYn1" value="Y" <?php echo ($userData->USE_YN == "Y")?"checked":""; ?> >
                        <label class="form-check-label" for="useYn1">사용</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="useYn" id="useYn2" value="N" <?php echo ($userData->USE_YN == "N" || is_null($userData->USE_YN))?"checked":""; ?>>
                        <label class="form-check-label" for="useYn2">사용 안 함</label>
                    </div>
                </div>
            </div>
        </fieldset >

        <div class="form-group row">
            <label for="adminGrade" class="col-sm-2 col-form-label" >권한</label>
            <div class="col-sm-10">
                <select class="form-control" name="adminGrade" id="adminGrade">
                    <option value="S" <?php echo ($userData->ADMIN_GRADE == "S")?"selected":""; ?>>슈퍼 관리자</option>
                    <option value="W" <?php echo ($userData->ADMIN_GRADE == "W")?"selected":""; ?>>필자</option>
                </select>
                <small id="adminGradeHelpBlock" class="form-text text-muted">
                    슈퍼 관리자는 관리자의 모든 권한이 부여됩니다. 반면에 필자는 글 쓰기와 오직 자신의 글만 관리할 수 있습니다. 
                </small>
            </div>
        </div>

        <fieldset  class="form-group">
            <div class="row">
                <legend class="col-form-label col-sm-2 pt-0">사전 승인 여부</legend>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="adminWriteAuth" id="adminWriteAuth1" value="Y" <?php echo ($userData->ADMIN_WRITE_AUTH == "Y")?"checked":""; ?> >
                        <label class="form-check-label" for="useYn1">사용</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="adminWriteAuth" id="adminWriteAuth2" value="N" <?php echo ($userData->ADMIN_WRITE_AUTH == "N" || is_null($userData->ADMIN_WRITE_AUTH))?"checked":""; ?>>
                        <label class="form-check-label" for="useYn2">사용 안 함</label>
                    </div>
                    <small id="adminWriteAuthHelpBlock" class="form-text text-muted">
                        필자가 작성한 글을 승인 검토 후 ㅍㅍㅅㅅ에 노출 시킬지 설정합니다.
                    </small>
                </div>
            </div>
        </fieldset >

    <?php } ?>

    <div class="form-group row">
        <label for="adminDesc" class="col-sm-2 col-form-label" >설명글</label>
        <div class="col-sm-10">
            <textarea class="form-control" id="adminDesc" name="adminDesc" rows="3"><?php echo $userData->ADMIN_DESC; ?></textarea>
            <small id="adminGradeHelpBlock" class="form-text text-muted">
                필자 목록에 노출 될 설명입니다.
            </small>
        </div>
    </div>

    <div class="btn-group flright" role="group">
        <button type="button" id="submitBtn" class="btn btn-primary btn-sm"><?php echo ($userData->ADMIN_SEQ > 0)?"수정":"등록"; ?></button>
        <?php if($adminData->ADMIN_GRADE == "S"){ ?>
            <button type="button" id="cancelBtn" class="btn btn-primary btn-sm">목록</button>
        <?php } ?>
    </div>
</form>

<script>
    $(document).ready(function(){
        $("#submitBtn").on("click", function(){
            formSubmit();
        });
        
        <?php if($adminData->ADMIN_GRADE == "S"){ ?>
            $("#cancelBtn").on("click", function(){
                if(confirm("작성한 내용이 유실 됩니다. 목록으로 돌아가시겠습니까?")){
                    location.href = "/admin/adminList";
                }
            });
        <?php } ?>

        $("#btn-dup").on("click", function(){
            dupCheck();
        });

        $('#customFile').on('change',function(e){
            var fileName = e.target.files[0].name;
            $(this).next('.custom-file-label').html(fileName);
        });

        $("#adminName").on("change", function(){
            $("#adminName").removeClass("is-invalid");
        })

        $("#adminId").on("keyup", function(){
            var adminId = $("#adminId").val();
            var idCheck = $("#idCheck").val();

            if(adminId == idCheck){
                $("#adminId").removeClass("is-invalid");
                $("#adminId").removeClass("is-valid");
                $("#dupCheck").val("Y");

                $("#btn-dup").attr( 'disabled', true );
            }else{
                $("#adminId").removeClass("is-invalid");
                $("#adminId").removeClass("is-valid");
                $("#dupCheck").val("N");

                $("#btn-dup").attr( 'disabled', false );
            }
        });

        $("#adminPassword").on("keyup", function(){
            var adminPassword = $(this).val();
            var adminPasswordChk = $("#adminPasswordChk").val(); 

            if(adminPasswordChk != "" && adminPasswordChk != undefined){
                if(adminPassword == adminPasswordChk){
                    $("#adminPassword").removeClass("is-invalid");
                    $("#adminPassword").addClass("is-valid");
                }else{
                    $("#adminPassword").siblings(".invalid-feedback").html("비밀번호 확인이 일치하지 않습니다.");
                    $("#adminPassword").removeClass("is-valid");
                    $("#adminPassword").addClass("is-invalid");
                }
            }
        });

        $("#adminPasswordChk").on("keyup", function(){
            var adminPassword = $("#adminPassword").val();
            var adminPasswordChk = $(this).val(); 

            if(adminPassword == adminPasswordChk){
                $("#adminPassword").removeClass("is-invalid");
                $("#adminPassword").addClass("is-valid");
            }else{
                $("#adminPassword").siblings(".invalid-feedback").html("비밀번호 확인이 일치하지 않습니다.");
                $("#adminPassword").removeClass("is-valid");
                $("#adminPassword").addClass("is-invalid");
            }
        });
    });

    function formSubmit(){
        var adminName = $("#adminName").val();
        var adminId = $("#adminId").val();
        var dupCheck = $("#dupCheck").val();
        var adminPassword = $("#adminPassword").val();
        var adminPasswordChk = $("#adminPasswordChk").val(); 

        if(adminName == "" || adminName == undefined){
            $("#adminName").siblings(".invalid-feedback").html("이름을 입력해주시기 바랍니다.");
            $("#adminName").removeClass("is-valid");
            $("#adminName").addClass("is-invalid");

            return;
        }

        if(dupCheck == "N"){
            $("#adminId").siblings(".invalid-feedback").html("아이디 중복확인이 필요합니다.");
            $("#adminId").removeClass("is-valid");
            $("#adminId").addClass("is-invalid");

            return;
        }

        if(adminId == "" || adminId == undefined){
            $("#adminId").siblings(".invalid-feedback").html("아이디를 입력해주시기 바랍니다.");
            $("#adminId").removeClass("is-valid");
            $("#adminId").addClass("is-invalid");

            return;
        }

        <?php
            if($userData->ADMIN_SEQ = 0){ 
        ?>

                if(adminPassword == "" || adminPassword == undefined){
                    $("#adminPassword").siblings(".invalid-feedback").html("비밀번호를 입력해주시기 바랍니다.");
                    $("#adminPassword").removeClass("is-valid");
                    $("#adminPassword").addClass("is-invalid");

                    return;
                }

        <?php
            }
        ?>

        if(adminPassword != adminPasswordChk){
            $("#adminPassword").siblings(".invalid-feedback").html("비밀번호 확인이 일치하지 않습니다.");
            $("#adminPassword").removeClass("is-valid");
            $("#adminPassword").addClass("is-invalid");

            return;
        }

        $("#dataForm").submit();
    }

    function dupCheck(){
        var id = $("#adminId").val();

        if(id == "" || id == undefined){
            $("#adminId").siblings(".invalid-feedback").html("아이디를 입력해주시기 바랍니다.");
            $("#adminId").removeClass("is-valid");
            $("#adminId").addClass("is-invalid");

            return;
        }else{
            $.ajax({
                method: "POST",
                url: "/admin/idCheck",
                data: { adminId: id }
            }).done(function( msg ) {
                if(msg == "TRUE"){
                    $("#dupCheck").val("Y");
                    $("#btn-dup").attr( 'disabled', true );
                    
                    $("#adminId").removeClass("is-invalid");
                    $("#adminId").addClass("is-valid");
                }else{
                    $("#dupCheck").val("N");
                    $("#btn-dup").attr( 'disabled', false );

                    $("#adminId").siblings(".invalid-feedback").html("중복 된 아이디입니다.");
                    $("#adminId").removeClass("is-valid");
                    $("#adminId").addClass("is-invalid");
                }
            });
        }
    }
</script>