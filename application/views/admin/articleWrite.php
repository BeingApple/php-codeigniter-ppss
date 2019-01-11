<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">기사 등록</h1>
</div>

<form id="dataForm" method="POST" action="/admin/articleWriteProc"> 
    <?php
        if($articleData->ARTICLE_SEQ > 0){
    ?>
            <input type="hidden" name="articleSeq" value="<?php echo $articleData->ARTICLE_SEQ; ?>" />
            <input type="hidden" name="mode" value="modify" />
    <?php
        }else{
    ?>
            <input type="hidden" name="mode" value="write" />
    <?php
        }
    ?>

    <div class="form-group row">
        <label for="articleTitle" class="col-sm-2 col-form-label" >제목</label>
        <div class="col-sm-10">
            <input type="text" id="articleTitle" name="articleTitle" value="<?php echo $articleData->ARTICLE_TITLE; ?>" class="form-control" placeholder="제목" aria-label="제목">
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-group row">
    <label for="articleCategory" class="col-sm-2 col-form-label" >카테고리</label>
        <div class="col-sm-10">
            <input type="text" id="articleCategory" name="articleCategory" value="<?php echo $articleData->ARTICLE_CATEGORY; ?>" class="form-control" placeholder="카테고리" aria-label="카테고리">
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-group row">
    <label for="articleContents" class="col-sm-2 col-form-label" >내용</label>
        <div class="col-sm-10">
            <textarea class="form-control" id="articleContents" name="articleContents" rows="20">
                <?php echo $articleData->ARTICLE_CONTENTS; ?>
            </textarea>
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <fieldset  class="form-group">
        <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">노출 여부</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="viewYn" id="viewYn1" value="Y" <?php echo ($articleData->VIEW_YN == "Y")?"checked":""; ?> >
                    <label class="form-check-label" for="viewYn1">노출</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="viewYn" id="viewYn2" value="N" <?php echo ($articleData->VIEW_YN == "N" || is_null($articleData->VIEW_YN))?"checked":""; ?>>
                    <label class="form-check-label" for="viewYn2">노출 안 함</label>
                </div>
            </div>
        </div>
    </fieldset >

    <div class="btn-group flright" role="group">
        <button type="button" id="submitBtn" class="btn btn-primary btn-sm"><?php echo ($articleData->ADMIN_SEQ > 0)?"수정":"등록"; ?></button>
        <?php if($adminData->ADMIN_GRADE == "S"){ ?>
            <button type="button" id="cancelBtn" class="btn btn-primary btn-sm">목록</button>
        <?php } ?>
    </div>
</form>

<form id="imageForm" style="width:0px; height:0; overflow:hidden">
    <input type="file" id="tinyImage" name="tinyImage" />
</form>

<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=pj2hc8mgwdb9lekszj6kezamkceikej1od3m13x0n5l7qz98"></script>
<script>
    $(document).ready(function(){
        tinymce.init({ 
            selector:'#articleContents',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount image'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | image | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ],
            file_browser_callback: function(field_name, url, type, win) {
                if(type=='image') $('#tinyImage').click();
            },
            language_url : '/js/language/ko_KR.js'
        });

        $("#tinyImage").on("change", function(){
            var form = $('#imageForm')[0];
            var data = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "/admin/editorImageUpload",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    eval(data);
                }
            });

            $(this).val("");
        });

        $("#submitBtn").on("click", function(){
            formSubmit();
        });
        
        $("#cancelBtn").on("click", function(){
            if(confirm("작성한 내용이 유실 됩니다. 목록으로 돌아가시겠습니까?")){
                location.href = "/admin/articleList";
            }
        });

        $("#articleTitle").on("change", function(){
            $("#articleTitle").removeClass("is-invalid");
        })
        $("#articleCategory").on("change", function(){
            $("#articleCategory").removeClass("is-invalid");
        })
    });

    function formSubmit(){
        var articleTitle = $("#articleTitle").val();
        var articleCategory = $("#articleCategory").val();

        if(articleTitle == "" || articleTitle == undefined){
            $("#articleTitle").siblings(".invalid-feedback").html("제목을 입력해주시기 바랍니다.");
            $("#articleTitle").removeClass("is-valid");
            $("#articleTitle").addClass("is-invalid");

            return;
        }

        if(articleCategory == "" || articleCategory == undefined){
            $("#articleCategory").siblings(".invalid-feedback").html("카테고리를 입력해주시기 바랍니다.");
            $("#articleCategory").removeClass("is-valid");
            $("#articleCategory").addClass("is-invalid");

            return;
        }

        $("#dataForm").submit();
    }
</script>