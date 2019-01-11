<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#">
        <img src="/images/ppss.png" width="36" height="36" alt="ㅍㅍㅅㅅ" />
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link active" href="/admin/adminList">
                    <span data-feather="users"></span>
                    관리자 / 필자
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="user-plus"></span>
                    필자 신청 목록
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="menu"></span>
                    카테고리 관리
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/articleList">
                    <span data-feather="file-text"></span>
                    기사 관리
                </a>
            </li>
        </ul>

        <a class="btn btn-dark" href="/admin/logout" >로그아웃</a>
    </div>
</nav>