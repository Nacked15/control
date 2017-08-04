<div class="index-box">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2 col-xs-offset-1">
            <div class="well naatik-box text-center">
                <div class="logo">
                    <img src="<?php echo Config::get('URL'); ?>assets/img/logo.png" with="50px" height="50px" alt="logo">
                </div>
                <h3 class="text-center naatik-title"> <strong>Instituto Naatik</strong></h3>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2 col-xs-offset-1">
            <div class="well login-box">
                <?php $this->renderFeedbackMessages(); ?>
                <h4 class="text-center text-naatik"> Iniciar Sesión</h4>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form action="<?php echo Config::get('URL'); ?>login/login" method="post">
                            <div class="form-group">
                                <input type="text" 
                                       name="user_name" 
                                       placeholder="Usuario o email"
                                       class="form-control"
                                       autocomplete="off" 
                                       required />
                            </div>
                            <div class="form-group">
                                <input type="password" 
                                   name="user_password" 
                                   placeholder="Contraseña"
                                   class="form-control" 
                                   required />
                            </div>

                            <label for="set_remember_me_cookie" class="remember-me-label">
                                <input type="checkbox" name="set_remember_me_cookie" class="remember-me-checkbox" />
                                Remember me for 2 weeks
                            </label>

                            <?php if (!empty($this->redirect)) { ?>
                                <input type="hidden" name="redirect" value="<?php echo $this->encodeHTML($this->redirect); ?>" />
                            <?php } ?>

                            <input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>" />
                            <div class="col-sm-4 col-sm-offset-4 text-center">
                                <input type="submit" class="btn btn-deep btn-raised center" value="Ingresar"/>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="link-forgot-my-password">
                    <br>
                    <a href="<?php echo Config::get('URL'); ?>login/requestPasswordReset" class="link">Olvide mi contraseña</a>
                </div>
            </div>
        </div>
    </div>
</div>
