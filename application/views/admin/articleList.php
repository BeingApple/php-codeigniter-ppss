<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">기사 목록</h1>
</div>

<div class="mb-4">
    <form id="serachForm" method="GET"> 
        <div class="form-group row">
            <div class="form-group col-md-6">
                <label for="articleTitle">제목</label>
                <input type="text" class="form-control" value="<?php echo $search['ARTICLE_TITLE'] ?>" id="articleTitle" name="articleTitle" placeholder="제목">
            </div>
            <div class="form-group col-md-6">
                <label for="adminName">필자</label>
                <input type="text" class="form-control" value="<?php echo $search['ADMIN_NAME'] ?>" id="adminName" name="adminName" placeholder="필자">
            </div>
        </div>
        <div class="form-group row">
            <div class="form-group col-md-6">
                <label for="articleCategory">카테고리</label>
                <select class="form-control" name="articleCategory" id="articleCategory">
                    <option value="">전체</option>
                    <?php
                        if(count($categoryList) > 0){
                            foreach($categoryList as $index => $data){
                    ?>
                            <option value="<?php echo $data->CATEGORY_NAME; ?>" <?php echo ($search['ARTICLE_CATEGORY'] == $data->CATEGORY_NAME)?"selected":""; ?>><?php echo $data->CATEGORY_NAME; ?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="articleContents">내용</label>
                <input type="text" class="form-control" value="<?php echo $search['ARTICLE_CONTENTS'] ?>" id="articleContents" name="articleContents" placeholder="내용">
            </div>
        </div>
        <div class="form-group row">
            <div class="form-group col-md-6">
                <label for="viewYn">노출 여부</label>
                <select class="form-control" name="viewYn" id="viewYn">
                    <option value="">전체</option>
                    <option value="Y" <?php echo ($search['VIEW_YN'] == "Y")?"selected":""; ?>>노출</option>
                    <option value="N" <?php echo ($search['VIEW_YN'] == "N")?"selected":""; ?>>노출 안 됨</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="authYn">승인 여부</label>
                <select class="form-control" name="authYn" id="authYn">
                    <option value="">전체</option>
                    <option value="Y" <?php echo ($search['AUTH_YN'] == "Y")?"selected":""; ?>>승인</option>
                    <option value="N" <?php echo ($search['AUTH_YN'] == "N")?"selected":""; ?>>승인 안 됨</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block">검색</button>
    </form>
</div>

<h2></h2>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th><input type="checkbox" id="checkAll" /></th>
                <th>#</th>
                <th>제목</th>
                <th>필자</th>
                <th>카테고리</th>
                <th>노출 여부</th>
                <th>승인 여부</th>
                <th>등록일자</th>
            </tr>
        </thead>

        <tbody>
            <?php
                if(count($articleList)<1){
            ?>
                    <tr>
                        <td colspan="9">결과가 존재하지 않습니다.</td>
                    </tr>
            <?php
                }else{
                    foreach($articleList as $index => $data){
            ?>
                        <tr>
                            <td><input type="checkbox" name="articleSeq" value="<?php echo $data->ARTICLE_SEQ; ?>" /></td>
                            <td><?php echo $offset + ($index + 1); ?></td>
                            <td><a href="/admin/articleWrite/<?php echo $data->ARTICLE_SEQ; ?>"><?php echo $data->ARTICLE_TITLE; ?></a></td>
                            <td><?php echo $data->ADMIN_NAME; ?></td>
                            <td><?php echo $data->ARTICLE_CATEGORY; ?></td>
                            <td><?php 
                                if($data->VIEW_YN == "Y")
                                    echo "노출";
                                else
                                    echo "노출 안 됨";
                            ?></td>
                            <td><?php 
                                if($data->AUTH_YN == "Y")
                                    echo "승인";
                                else
                                    echo "승인 안 됨";
                            ?></td>
                            <td><?php echo $data->REG_DATE; ?></td>
                        </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>
    <?php echo $pagination; ?>
</div>

<div class="d-flex bd-highlight mb-3">
    <?php if($adminData->ADMIN_GRADE == "S"){ ?>
        <div class="btn-group p-2 bd-highlight" role="group">
            <button class="btn btn-primary" id="authBtn">승인</button>
            <button class="btn btn-secondary" id="unauthBtn">미승인</button>
        </div>
    <?php } ?>
    <div class="btn-group p-2 bd-highlight" role="group">
        <button class="btn btn-danger" id="btnDelete">삭제</button>
    </div>
    <div class="btn-group ml-auto p-2 bd-highlight" role="group">
        <a class="btn btn-primary" href="/admin/articleWrite" role="button">등록</a>
    </div>
</div>

<script>
$(document).ready(function(){
    $("#checkAll").on("change", function(){
        var checked = $(this).is(":checked");

        $("input[name=articleSeq]").each(function(){
            $(this).prop("checked", checked);
        });
    });

    $("#btnDelete").on("click", function(){
        articleDelete();
    });

    <?php if($adminData->ADMIN_GRADE == "S"){ ?>
        $("#authBtn").on("click", function(){
            articleAuth("Y");
        });

        $("#unauthBtn").on("click", function(){
            articleAuth("N");
        });
    <?php } ?>
});

<?php if($adminData->ADMIN_GRADE == "S"){ ?>
    function articleAuth(auth){
        var checked = $("input[name=articleSeq]:checked");

        if(checked.length > 0){
            var text = (auth == "Y")? "승인" : "승인 취소";

            if(confirm(text+" 하시겠습니까?")){
                var checkboxValues = [];
                $("input[name=articleSeq]:checked").each(function(index){
                    checkboxValues.push($(this).val());
                });

                var allData = { "articleSeqs": checkboxValues, "authYn": auth };

                $.ajax({
                    type: "POST",
                    url: "/admin/articleAuth",
                    data: allData,
                    success: function (data) {
                        if(data == "TRUE"){
                            alert(text+" 되었습니다.");
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
<?php } ?>

function articleDelete(){
    var checked = $("input[name=articleSeq]:checked");

    if(checked.length > 0){
        if(confirm("삭제하시겠습니까?")){
            var checkboxValues = [];
            checked.each(function(index){
                checkboxValues.push($(this).val());
            });

            var allData = { "articleSeqs": checkboxValues };

            $.ajax({
                type: "POST",
                url: "/admin/articleDelete",
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