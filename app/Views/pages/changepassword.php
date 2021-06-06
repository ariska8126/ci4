<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="container mt-5">

    <form method="POST" action="<?= base_url('ForgotPassword/changepassword/' . $username); ?>">
        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirmpassword" class="form-control">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </div>
    </form>

</div>
<?= $this->endSection(); ?>