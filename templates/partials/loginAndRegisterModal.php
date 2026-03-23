<!-- LOGIN MODAL -->
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Login</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="mb-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username">
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password">
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

<!-- SIGN UP MODAL -->
<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Sign-up</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form>
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Re-enter Password</label>
                    <input type="password" class="form-control">
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