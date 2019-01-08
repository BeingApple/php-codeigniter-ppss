<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2">관리자 / 필자 목록</h1>
</div>

<div>
    검색영역
</div>

<h2></h2>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>이름</th>
                <th>권한</th>
                <th>마지막 로그인 일자</th>
                <th>등록일자</th>
            </tr>
        </thead>

        <tbody>
            <?php
                if(count($adminList)<1){
            ?>
                    <tr>
                        <td colspan="5">결과가 존재하지 않습니다.</td>
                    </tr>
            <?php
                }else{
                    foreach($adminList as $index => $data){
            ?>
                        <tr>
                            <td>1</td>
                            <td><?php echo $data->ADMIN_NAME; ?></td>
                            <td><?php 
                                if($data->ADMIN_GRADE == "S")
                                    echo "슈퍼 관리자";
                                else
                                    echo "필자";
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
</div>
<div class="btn-group flright" role="group">
    <a class="btn btn-primary btn-sm" href="/admin/adminWrite" role="button">등록</a>
</div>