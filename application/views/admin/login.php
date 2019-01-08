<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="ㅍㅍㅅㅅ 관리자 로그인">
    <meta name="author" content="조용비">
    <link rel="icon" href="/images/ppss-100x100.png" sizes="32x32">
	<link rel="icon" href="/images/ppss.png" sizes="192x192">


    <title>ㅍㅍㅅㅅ | 관리자 로그인</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- Custom styles for this template -->
    <link href="/css/login.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" method="POST">
      <img class="mb-4" src="/images/ppss.png" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">ㅍㅍㅅㅅ 관리자</h1>
      <label for="inputEmail" class="sr-only">아이디</label>
      <input type="text" id="inputEmail" name="adminId" value="<?php echo isset($rememberId) ? $rememberId : '' ?>" class="form-control" placeholder="아이디" required autofocus>
      <label for="inputPassword" class="sr-only">비밀번호</label>
      <input type="password" id="inputPassword" name="adminPassword" class="form-control" placeholder="비밀번호" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" name="rememberMe" value="Y"> 아이디 저장
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">로그인</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
    </form>
  </body>
</html>
