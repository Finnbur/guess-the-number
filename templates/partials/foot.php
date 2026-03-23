    </div>
</div>

<footer class="bg-body-tertiary">
    <div class="text-center p-3">
        <p>© 2026 Guess the number</p>
    </div>
</footer>

<!-- modals -->
<?php
if(!$_SESSION['loggedIn']) {
    require_once 'loginModal.php';
    require_once 'registerModal.php'; 
} 
?>

</body>
</html>
