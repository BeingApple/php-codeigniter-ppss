<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">관리자 / 필자 목록</h1>
</div>

<div class="mb-4">
    <form id="serachForm" method="GET"> 
        <div class="form-group row">
            <div class="form-group col-md-6">
                <label for="adminName">이름</label>
                <input type="text" class="form-control" value="<?php echo $search['ADMIN_NAME'] ?>" id="adminName" name="adminName" placeholder="이름">
            </div>
            <div class="form-group col-md-6">
                <label for="adminId">아이디</label>
                <input type="text" class="form-control" value="<?php echo $search['ADMIN_ID'] ?>" id="adminId" name="adminId" placeholder="아이디">
            </div>
        </div>
        <div class="form-group row">
            <div class="form-group col-md-6">
                <label for="adminGrade">권한</label>
                <select class="form-control" name="adminGrade" id="adminGrade">
                    <option value="">전체</option>
                    <option value="S" <?php echo ($search['ADMIN_GRADE'] == "S")?"selected":""; ?>>슈퍼 관리자</option>
                    <option value="W" <?php echo ($search['ADMIN_GRADE'] == "W")?"selected":""; ?>>필자</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="useYn">사용여부</label>
                <select class="form-control" name="useYn" id="useYn">
                    <option value="">전체</option>
                    <option value="Y" <?php echo ($search['USE_YN'] == "Y")?"selected":""; ?>>사용</option>
                    <option value="N" <?php echo ($search['USE_YN'] == "N")?"selected":""; ?>>사용 안 함</option>
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
                <th>썸네일</th>
                <th>이름</th>
                <th>아이디</th>
                <th>권한</th>
                <th>사용 여부</th>
                <th>마지막 로그인 일자</th>
                <th>등록일자</th>
            </tr>
        </thead>

        <tbody>
            <?php
                if(count($adminList)<1){
            ?>
                    <tr>
                        <td colspan="8">결과가 존재하지 않습니다.</td>
                    </tr>
            <?php
                }else{
                    foreach($adminList as $index => $data){
            ?>
                        <tr>
                            <td><?php echo $offset + ($index + 1); ?></td>
                            <td>
                                <?php if($data->ADMIN_FILE_NAME != NULL){ ?>
                                    <img src="/uploads/ppss/<?php echo $data->ADMIN_FILE_NAME; ?>" />
                                <?php } ?>
                            </td>
                            <td><a href="/admin/adminWrite/<?php echo $data->ADMIN_SEQ; ?>"><?php echo $data->ADMIN_NAME; ?></a></td>
                            <td><?php echo $data->ADMIN_ID; ?></td>
                            <td><?php 
                                if($data->ADMIN_GRADE == "S")
                                    echo "슈퍼 관리자";
                                else
                                    echo "필자";
                            ?></td>
                            <td><?php 
                                if($data->USE_YN == "Y")
                                    echo "사용";
                                else
                                    echo "사용 안 함";
                            ?></td>
                            <td><?php echo $data->LAST_LOGIN_DATE; ?></td>
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
    <a class="btn btn-primary btn-sm" href="/admin/adminWrite" role="button">등록</a>
</div>