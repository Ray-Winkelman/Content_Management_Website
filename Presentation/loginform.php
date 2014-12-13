<form action="CheckLoginCredentials.php" method=POST class="form-horizontal"
      role="form" id="Form">

    <div class="form-group">
        <label for="username" class="col-sm-4 control-label">Username:</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="username" name="username"
                   placeholder="Username">
        </div>
    </div>

    <div class="form-group">
        <label for="password" class="col-sm-4 control-label">Password:</label>
        <div class="col-sm-4">
            <input type="password" class="form-control" id="password" name="password">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">
            <button type="submit"  style="float: right;" class="btn
            btn-default">Login</button>
        </div>
    </div>

</form>



