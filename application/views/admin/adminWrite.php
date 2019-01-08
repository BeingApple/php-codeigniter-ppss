<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2">관리자 / 필자 등록</h1>
</div>

<form method="POST" enctype="multipart/form-data"> 
    <div class="form-group">
        <label for="image">썸네일</label>
        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="image">
                <label class="custom-file-label" for="image">파일을 선택하세요</label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="adminId">아이디</label>
        <div class="input-group mb-3">
            <input type="text" id="adminId" name="adminId" class="form-control" placeholder="아이디" aria-label="아이디" aria-describedby="btn-dup">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="btn-dup">중복확인</button>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="adminPassword">비밀번호</label>
        <input type="password" id="adminPassword" name="adminPassword" class="form-control" placeholder="비밀번호" aria-label="비밀번호">
    </div>
    <div class="form-group">
        <label for="adminPasswordChk">비밀번호 확인</label>
        <input type="password" id="adminPasswordChk" class="form-control" placeholder="비밀번호 확인" aria-label="비밀번호 확인">
    </div>

    <div class="form-group">
        <label for="adminGrade">권한</label>
        <select class="form-control" id="adminGrade">
            <option value="S">슈퍼 관리자</option>
            <option value="W">필자</option>
        </select>
    </div>

    <div class="btn-group flright" role="group">
        <button type="submit" class="btn btn-primary btn-sm">등록</button>
        <button type="button" class="btn btn-primary btn-sm">취소</button>
    </div>
</form>