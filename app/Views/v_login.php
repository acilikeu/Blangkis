<?= $this->extend('layout_clear') ?>
<?= $this->section('content') ?>

<?php
$username = [
    'name' => 'username',
    'id' => 'username',
    'class' => 'form-control'
];
$password = [
    'name' => 'password',
    'id' => 'password',
    'class' => 'form-control'
];
?>

<style>
    body {
        background-color: #FFF9F0;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .btn-coklat {
        background-color: #8B4513;
        color: #fff;
        border: none;
    }

    .btn-coklat:hover {
        background-color: #A0522D;
    }

    .form-label {
        color: #5C3B1E;
        font-weight: 500;
    }

    .card-title {
        color: #8B4513;
        font-weight: 600;
    }

    .text-small {
        font-size: 0.9rem;
        color: #7A5E44;
    }
</style>

<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex flex-column align-items-center py-3">
                    <img src="<?= base_url() ?>NiceAdmin/assets/img/BLANGKONCOKLAT.PNG" alt="logo" style="height: 70px;">
                    <span style="color:#8B4513; font-size: 2rem; font-weight: 800; margin-top: 0px;">BLANGKIS</span>
                </div>

                <div class="card w-100 mb-3">
                    <div class="card-body">

                        <div class="pt-4 pb-2 text-center">
                            <h5 class="card-title">Login to Your Account</h5>
                            <p class="text-small">Enter your username & password to login</p>
                        </div>

                        <?php if (session()->getFlashData('failed')): ?>
                            <div class="alert alert-danger text-center"><?= session()->getFlashData('failed') ?></div>
                        <?php endif; ?>

                        <?= form_open('login', ['class' => 'row g-3 needs-validation']) ?>

                        <div class="col-12">
                            <label for="yourUsername" class="form-label">Username</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                <?= form_input($username) ?>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="yourPassword" class="form-label">Password</label>
                            <?= form_password($password) ?>
                        </div>

                        <div class="col-12">
                            <?= form_submit('submit', 'Login', ['class' => 'btn btn-coklat w-100']) ?>
                        </div>

                        <?= form_close() ?>
                    </div>

                    <div class="card-footer text-center">
                        <a href="<?= base_url('auth/google') ?>" class="btn btn-danger w-100">
                            <i class="bi bi-google"></i> Login dengan Google
                        </a>
                    </div>
                </div>
                <!-- <div class="credits mt-3 text-muted text-center" style="font-size: 0.8rem;">
          Designed by <a href="https://bootstrapmade.com/" target="_blank">BootstrapMade</a>
        </div> -->
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>