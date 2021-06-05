<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                    <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                        and we'll send you a link to reset your password!</p>
                                </div>
                                <form class="user">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                    </div>
                                    <a href="login.html" class="btn btn-primary btn-user btn-block">
                                        Reset Password
                                    </a>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="register.html">Create an Account!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="login.html">Already have an account? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="comtainer">
    <div class="row">
        <div class="col">

            <h1>Data User</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                        <th scope="col">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($user as $u) :  ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $u['username']; ?> </td>
                            <td><?= $u['email']; ?> </td>
                            <td><?= $u['password']; ?> </td>
                            <td>
                                <a href="detailUser/<?= $u['email']; ?>" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>