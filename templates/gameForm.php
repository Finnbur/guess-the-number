<h3 class="mb-4">
    Guess a number between 
    <strong><?php echo $_SESSION['min']; ?></strong> 
    and 
    <strong><?php echo $_SESSION['max']; ?></strong>
</h3>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <!-- response -->
    <?php if(isset($_SESSION['response'])): ?>
        <div class="alert alert-<?php echo $_SESSION['response']['type']; ?> text-center">
            <?php echo htmlspecialchars($_SESSION['response']['message']); ?>
        </div>
        <?php unset($_SESSION['response']); ?>
    <?php endif; ?>

    <!-- amount of guesses left -->
    <div class="list-group list-group-flush">
        <p><?php echo count($_SESSION['guesses']); ?>/<?php echo $_SESSION['maxGuesses']; ?> Guesses</p>
    </div>

    <!-- guess reset and play again buttons -->
    <div class="input-group input-group-lg mb-1">
        <input type="number" class="form-control" id="guess" name="guess" placeholder="Guess here..." required>
        <button type="submit" name="action" value="guess" class="btn btn-primary px-4 fw-semibold">
            Guess
        </button>
    </div>
    <div class="d-flex gap-2 mb-2">
        <button type="submit" name="action" value="reset" class="btn btn-outline-secondary flex-fill btn-sm" formnovalidate>
            Reset Game
        </button>
        <button type="submit" name="action" value="again" class="btn btn-outline-primary flex-fill btn-sm" formnovalidate>
            Play Again
        </button>
    </div>

    <!-- old guesses list -->
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
</form>