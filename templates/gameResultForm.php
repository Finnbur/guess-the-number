<?php
if($_SESSION['gameWon'] == true) {
    echo "<div class='text-center mb-4'><h1><span class='badge bg-success rounded-pill'>GAME WON</span></h1></div>";
} else {
    echo "<div class='text-center mb-4'><h1><span class='badge bg-danger rounded-pill'>GAME LOST</span></h1></div>";
}
?>


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <!-- Guesses -->
    <div class="list-group list-group-flush">
        <h3><?php echo count($_SESSION['guesses']); ?>/<?php echo $_SESSION['maxGuesses']; ?> Guesses</h3>
    </div>

    <div class="d-grid gap-2">
        <button type="submit" name="action" value="again" class="btn btn-primary btn-lg" formnovalidate>
            Play Again
        </button>
        <button type="submit" name="action" value="reset" class="btn btn-secondary" formnovalidate>
            Reset Game
        </button>

        <?php require_once 'partials/guessesList.php'; ?>
    </div>
</form>