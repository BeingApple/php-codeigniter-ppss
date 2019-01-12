<?php echo $template_name; ?>
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
                <a class="nav-link <?php echo ($position == "profile")?"active":""; ?>" href="/admin/myProfile">
                    <span data-feather="user"></span>
                    내 프로필 관리
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo ($position == "article")?"active":""; ?>" href="/admin/articleList">
                    <span data-feather="file-text"></span>
                    기사 목록
                </a>
            </li>
        </ul>

        <a class="btn btn-dark" href="/admin/logout" ><?php echo $adminData->ADMIN_NAME; ?> 로그아웃</a>
    </div>
</nav>