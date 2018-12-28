<?php echo $this->Form->create('User');?>
<div class="container">

        <div class="row">
            <div class="col-md-4 col-md-offset-4" style="">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Welcome to City Trust System</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="data[User][username]" type="username" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="data[User][password]" type="password" value="">
                                </div>
                                <!-- <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div> -->
                                <!-- Change this to a button or input when using this as a form -->
                                <div>
                                     <?php echo $this->Session->flash('auth');?>
                                </div>
                                <?php echo $this->Form->end(__('Submit', true));?>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>