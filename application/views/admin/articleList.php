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
                    <option value="경제" <?php echo ($search['ARTICLE_CATEGORY'] == "경제")?"selected":""; ?>>경제</option>
                    <option value="사회" <?php echo ($search['ARTICLE_CATEGORY'] == "사회")?"selected":""; ?>>사회</option>
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
                        <td colspan="8">결과가 존재하지 않습니다.</td>
                    </tr>
            <?php
                }else{
                    foreach($articleList as $index => $data){
            ?>
                        <tr>
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
<div class="btn-group flright" role="group">
    <a class="btn btn-primary btn-sm" href="/admin/articleWrite" role="button">등록</a>
</div>