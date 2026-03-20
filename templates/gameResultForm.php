<?php
if($_SESSION['gameWon'] == true) {
    echo "<h1>GAME WON</h1>";
} else {
    echo "<h1>GAME LOST</h1>";
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

        <h3 class="fw-semibold">Guesses</h3>
        <div class="list-group list-group-flush">
            <?php if (!empty($_SESSION['guesses'])): ?>
                <?php foreach ($_SESSION['guesses'] as $index => $guess): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>Guess <?php echo $index + 1; ?>: <?php echo htmlspecialchars($guess['guess']); ?></span>
                        <span class="badge bg-<?php echo $guess['type']; if($guess['type'] == "warning") { echo " text-dark"; }?> rounded-pill"><?php echo htmlspecialchars($guess['message']) ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-muted small">No guesses done.</div>
            <?php endif; ?>
        </div>
    </div>
</form>