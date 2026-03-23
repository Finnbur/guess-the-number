<!-- LOGIN MODAL -->
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Login</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <?php if(isset($_SESSION['response']) && $_SESSION['response']['location'] == "login"): ?>
                <div class="alert alert-<?php echo $_SESSION['response']['type']; ?> text-center">
                    <?php echo htmlspecialchars($_SESSION['response']['message']); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="mb-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <button type="submit" name="action" value="login" class="btn btn-primary w-100">Login</button>
            </form>
        </div>

        <div class="modal-footer justify-content-center">
            <span>Don't have an account?</span>
            <button 
            class="btn btn-link"
            data-bs-target="#registerModal"
            data-bs-toggle="modal"
            data-bs-dismiss="modal">
            Sign-up
            </button>
        </div>

        </div>
    </div>
</div>

<?php if(isset($_SESSION['response']) && $_SESSION['response']['location'] == "login"): ?>
<script>
    var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
    loginModal.show();
</script>
<?php unset($_SESSION['response']); ?>
<?php endif; ?>