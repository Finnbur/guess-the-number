<?php
if($_SESSION['gamemode'] === 'basic') {
    if($_SESSION['gameWon'] == true) {
        ?>
            <div class='text-center mb-4'><h1><span class='badge bg-success rounded-pill'>GAME WON (<?php echo $_SESSION['score'] ?>)</span></h1></div>
        <?php
    } else {
        ?>
            <div class='text-center mb-4'><h1><span class='badge bg-danger rounded-pill'>GAME LOST</span></h1></div>
        <?php
    }
} elseif($_SESSION['gamemode'] === 'rush') {
    ?>
        <div class='text-center mb-4'><h1><span class='badge bg-success rounded-pill'><?php echo $_SESSION['correctCount'] ?> Correct (<?php echo $_SESSION['score'] ?>)</span></h1></div>
    <?php
}
?>


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="row align-items-center mb-4 g-3">
        <!-- amount of Guesses -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Guesses</span>
                    <span class="badge bg-primary fs-6">
                        <?php echo count($_SESSION['guesses']); ?> / <?php echo $_SESSION['maxGuesses']; ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Time it took -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Time </span>
                    <span id="timeText" class="badge bg-success fs-6">
                        <?php echo $_SESSION['endTime'] - $_SESSION['startTime']; ?>s
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="d-grid gap-2">
        <button type="submit" name="action" value="again" class="btn btn-primary btn-lg" formnovalidate>
            Play Again
        </button>
        <button type="submit" name="action" value="reset" class="btn btn-secondary" formnovalidate>
            Reset Game
        </button>
        <?php if (!isset($_SESSION['saveScore']) && $_SESSION['loggedIn'] == false): ?>
            <button type="submit" name="action" value="saveScore" class="btn btn-warning" formnovalidate>
                Login to save score
            </button>
        <?php endif; ?>

        <?php require_once 'partials/guessesList.php'; ?>
    </div>
</form>