<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #CC99FF; position: fixed; top: 0; width: 100%;">
  <a class="navbar-brand" href="index.php">Tenant Tracker</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="btn btn-outline-dark" href="index.php" >Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item" style="padding-right: 15px"></li>
      <li class="nav-item active">
        <?php if($_SESSION['uid'] == 'admin') echo '<li class="nav-item">
        <a  href="admin.php" role="button" class="btn btn-outline-danger">Admin</a>' ?>
      </li>
    </ul>
    <?php if(isset($_SESSION['uid'])) {
      echo '<a href="/csc301/signOut.php" role="button" class="btn btn-light">SIGN OUT</a>';
    }
    else echo '<a href="/csc301/signIn.php" role="button" class="btn btn-light">SIGN IN</a> OR <a href="/csc301/signUp.php" role="button" class="btn btn-light">SIGN UP</a>';
    ?>
  </div>
</nav>
<br><br><br>