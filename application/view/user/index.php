<div class="container">
    <ol class="breadcrumb">
        <li><a href="javascript:void(0)">Inicio</a></li>
        <li><a href="javascript:void(0)" class="active">Usuario</a></li>
    </ol> 
    <div class="well">
        <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <h3 class="text-center text-primary">Mi Perfil</h3>
            <div class="card-primary">
                <?php $this->renderFeedbackMessages(); ?>
                <div class="card-avatar">
                    <img src="<?= $this->user_avatar_file; ?>" alt="avatar">
                </div>
                <div class="card-title">
                    <h3 class="text-center"><?= $this->user_name; ?></h3>
                </div>
                <div class="card-body">
                    <p class="text-center"><strong>Email:</strong> <?= $this->user_email; ?></p>
                    <p class="text-center"><strong>Account type:</strong> <?= $this->user_account_type; ?></p>
                </div> 
            </div>
        </div>
        </div>
    </div>
</div>
