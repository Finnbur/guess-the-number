<!-- SIGN UP MODAL -->
<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Sign-up</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <?php if(isset($_SESSION['response']) && $_SESSION['response']['location'] == "register"): ?>
                <div class="alert alert-<?php echo $_SESSION['response']['type']; ?> text-center">
                    <?php echo htmlspecialchars($_SESSION['response']['message']); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="mb-3">
                    <label>Re-enter Password</label>
                    <input type="password" class="form-control" name="cpassword" required>
                </div>

                <button type="submit" name="action" value="register" class="btn btn-primary w-100">Register</button>
            </form>
        </div>

        <div class="modal-footer justify-content-center">
            <span>Already have an account?</span>
            <button 
            class="btn btn-link"
            data-bs-target="#loginModal"
            data-bs-toggle="modal"
            data-bs-dismiss="modal">
            Login
            </button>
        </div>

        </div>
    </div>
</div>

<?php if(isset($_SESSION['response']) && $_SESSION['response']['location'] == "register"): ?>
<script>
    var loginModal = new bootstrap.Modal(document.getElementById('registerModal'));
    loginModal.show();
</script>
<?php unset($_SESSION['response']); ?>
<?php endif; ?>