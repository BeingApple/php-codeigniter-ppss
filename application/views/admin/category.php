<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">카테고리 관리</h1>
</div>

<div class="container-fluid mt-4">
    <div class="row justify-content-md-center">
        <div class="col-12 col-md-5">
            <h5>새 카테고리 추가</h5>
            <form id="dataForm" method="POST" action="/admin/categoryProc"> 
                <?php
                    if($categoryData->CATEGORY_SEQ > 0){
                ?>
                        <input type="hidden" name="mode" value="modify" />
                        <input type="hidden" name="categorySeq" id="categorySeq" value="<?php echo $categoryData->CATEGORY_SEQ; ?>" />
                        <input type="hidden" name="parentSeq" id="parentSeq" value="<?php echo $categoryData->PARENT_SEQ; ?>" />
                        <input type="hidden" name="categoryLevel" id="categoryLevel" value="<?php echo $categoryData->CATEGORY_LEVEL; ?>" />
                <?php
                    }else{
                ?>
                        <input type="hidden" name="mode" value="write" />
                        <input type="hidden" name="categorySeq" id="categorySeq" value="0" />
                        <input type="hidden" name="parentSeq" id="parentSeq" value="0" />
                        <input type="hidden" name="categoryLevel" id="categoryLevel" value="1" />
                <?php
                    }
                ?>

                <div class="form-group row">
                    <label for="categoryName" class="col-sm-5 col-form-label" >이름</label>
                    <div class="col-sm-12">
                        <input type="text" id="categoryName" name="categoryName" value="<?php echo $categoryData->CATEGORY_NAME; ?>" class="form-control" placeholder="이름" aria-label="이름">
                        <div class="invalid-feedback"></div>
                        <small id="categoryNameHelpBlock" class="form-text text-muted">
                            사이트에 표시될 이름입니다.
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="categorySlug" class="col-sm-5 col-form-label" >슬러그</label>
                    <div class="col-sm-12">
                        <input type="text" id="categorySlug" name="categorySlug" value="<?php echo $categoryData->CATEGORY_SLUG; ?>" class="form-control" placeholder="슬러그" aria-label="슬러그">
                        <div class="invalid-feedback"></div>
                        <small id="categorySlugHelpBlock" class="form-text text-muted">
                            URL에서 사용할 이름입니다.
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="categoryParent" class="col-sm-5 col-form-label" >상위 카테고리</label>
                    <div class="col-sm-12">
                        <select class="form-control" name="categoryParent" id="categoryParent">
                            <option value="">선택 안 함</option>
                            <?php
                                if(count($parentList) > 0){
                                    foreach($parentList as $index => $data){
                            ?>
                                    <option value="<?php echo $data->CATEGORY_SEQ; ?>" category-level="<?php echo $data->CATEGORY_LEVEL ?>" <?php echo ($categoryData->CATEGORY_LEVEL > 1 && ($categoryData->PARENT_SEQ == $data->CATEGORY_SEQ))?"selected":""; ?> ><?php echo $data->CATEGORY_NAME; ?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="categoryDesc" class="col-sm-5 col-form-label" >설명</label>
                    <div class="col-sm-12">
                        <textarea class="form-control" id="categoryDesc" name="categoryDesc" rows="3"><?php echo $categoryData->CATEGORY_DESC; ?></textarea>
                    </div>
                </div>
                
                <fieldset  class="form-group">
                    <div class="row">
                        <legend class="col-form-label col-sm-5 pt-0">노출 여부</legend>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="viewYn" id="viewYn1" value="Y" <?php echo ($categoryData->VIEW_YN == "Y")?"checked":""; ?>>
                                <label class="form-check-label" for="viewYn1">노출</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="viewYn" id="viewYn2" value="N" <?php echo ($categoryData->VIEW_YN == "N" || is_null($categoryData->VIEW_YN))?"checked":""; ?>>
                                <label class="form-check-label" for="viewYn2">노출 안 함</label>
                            </div>
                        </div>
                    </div>
                </fieldset >

                <div class="d-flex bd-highlight mb-3">        
                    <div class="btn-group ml-auto p-2 bd-highlight" role="group">
                        <button type="button" id="submitBtn" class="btn btn-primary"><?php echo ($categoryData->CATEGORY_SEQ > 0)?"수정":"등록"; ?></button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-12 col-md-7">
            <div class="d-flex bd-highlight mb-3">
                <div class="btn-group ml-auto p-2 bd-highlight" role="group">
                    <button class="btn btn-sm btn-danger" id="btnDelete">삭제</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll" /></th>
                            <th>이름</th>
                            <th>슬러그</th>
                            <th>노출</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            if(count($categoryList)<1){
                        ?>
                                <tr>
                                    <td colspan="5">결과가 존재하지 않습니다.</td>
                                </tr>
                        <?php
                            }else{
                                foreach($categoryList as $index => $data){
                        ?>
                                <tr>
                                    <td><input type="checkbox" name="categorySeq" value="<?php echo $data->CATEGORY_SEQ; ?>" /></td>
                                    <td><?php echo $data->CATEGORY_NAME; ?></td>
                                    <td><?php echo $data->CATEGORY_SLUG; ?></td>
                                    <td><?php echo $data->VIEW_YN; ?></td>
                                    <td class="d-flex justify-content-end"><a href="/admin/category/<?php echo $data->CATEGORY_SEQ; ?>" class="btn btn-primary btn-sm" id="btnModify">수정</a></td>
                                </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#submitBtn").on("click", function(){
            formSubmit();
        });

        $("#btnDelete").on("click", function(){
            categoryDelete();
        });

        $("#checkAll").on("change", function(){
            var checked = $(this).is(":checked");

            $("input[name=categorySeq]").each(function(){
                $(this).prop("checked", checked);
            });
        });

        $("#categoryName").on("change", function(){
            $("#categoryName").removeClass("is-invalid");
        })

        $("#categorySlug").on("change", function(){
            $("#categorySlug").removeClass("is-invalid");
        })

        $("#categoryParent").on("change", function(){
            parentChange();
        });
    });

    function parentChange(){
        var select = $("#categoryParent");
        var parentSeq = select.val();

        if(parentSeq != undefined && parentSeq != ""){
            $("#parentSeq").val(parentSeq);

            var categoryLevel = Number($("#categoryParent").find(":selected").attr("category-level"));

            $("#categoryLevel").val(categoryLevel + 1);
        }else{
            $("#parentSeq").val(0);
            $("#categoryLevel").val(1);
        }
    }

    function formSubmit(){
        var categoryName = $("#categoryName").val();
        var categorySlug = $("#categorySlug").val();

        if(categoryName == "" || categoryName == undefined){
            $("#categoryName").siblings(".invalid-feedback").html("이름을 입력해주시기 바랍니다.");
            $("#categoryName").removeClass("is-valid");
            $("#categoryName").addClass("is-invalid");

            return;
        }

        if(categorySlug == "" || categorySlug == undefined){
            $("#categorySlug").siblings(".invalid-feedback").html("슬러그 입력해주시기 바랍니다.");
            $("#categorySlug").removeClass("is-valid");
            $("#categorySlug").addClass("is-invalid");

            return;
        }

        $("#dataForm").submit();
    }
    function categoryDelete(){
        var checked = $("input[name=categorySeq]:checked");

        if(checked.length > 0){
            if(confirm("삭제하시겠습니까? 부모 메뉴일 경우 하위메뉴도 함께 삭제됩니다.")){
                var checkboxValues = [];
                checked.each(function(index){
                    checkboxValues.push($(this).val());
                });

                var allData = { "categorySeqs": checkboxValues };

                $.ajax({
                    type: "POST",
                    url: "/admin/categoryDelete",
                    data: allData,
                    success: function (data) {
                        if(data == "TRUE"){
                            alert("삭제 되었습니다.");
                        }else{
                            alert("잘못된 접근입니다.");
                        }

                        location.reload();
                    }
                });
            }
        }else{
            alert("선택 된 항목이 없습니다.");
        }
    }
</script>