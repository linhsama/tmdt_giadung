<?php
if (isset($_SESSION['user'])) {
  unset($_SESSION['user']);
}
if (isset($_SESSION['url'])) {
  unset($_SESSION['url']);
}
if (isset($_SERVER["HTTP_REFERER"])) {
  if (strlen(strstr($_SERVER["HTTP_REFERER"], "dang-nhap")) < 1) {
    if (strlen(strstr($_SERVER["HTTP_REFERER"], "chinh-sua")) < 1) {
      if (strlen(strstr($_SERVER["HTTP_REFERER"], "dang-ky")) < 1) {
        $_SESSION['url'] = $_SERVER["HTTP_REFERER"];
      }
    }
  }
}

$url = $_SESSION['url']  ?? '../../user/';
?>
<div class="auth-container row">
  <div class="logo-wrapper col-4">
    <img src="../assets/images/ong3.png" alt="login" class="img-fluid">
  </div>
  <div class="form-wrapper col-8">
    <img src="../assets/images/ong2.png" alt="logo" class="img-fluid">
    <h3 class="text-title mb-5">USER - LOGIN</h3>
    <form action="pages/action.php?req=dang-nhap" method="post">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required placeholder="Nhập email">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required placeholder="Nhập password">
      </div>
      <br>
      <div class="form-group text-center">
        <button class="btn btn-primary w-100" type="submit">Login</button>
      </div>
      <input type="hidden" name="url" id="url" class="form-control" value="<?= $url ?>" />

    </form>
    <hr>
    <p class="footer-text">Bạn chưa có tài khoản? <a href="index.php?pages=dang-ky" class="text-primary">Đăng ký
        ngay!</a></p>
  </div>
</div>