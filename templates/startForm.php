
<h3>Start Game</h3>
<p class="text-muted small mb-4">To save scores log in</p>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="d-flex gap-2 mb-2">
        <div class="mb-3 flex-fill">
            <label for="min" class="form-label">Minimum Number</label>
            <input type="number" class="form-control" name="min" value="<?php echo $_SESSION['min'] ?>" required>
        </div>

        <div class="mb-3 flex-fill">
            <label for="max" class="form-label">Maximum Number</label>
            <input type="number" class="form-control" name="max" value="<?php echo $_SESSION['max'] ?>" required>
        </div>
    </div>

    <div class="d-flex gap-2 mb-2">
        <div class="mb-3 flex-fill">
            <label for="maxGuesses" class="form-label">Maximum Guesses</label>
            <input type="number" class="form-control " name="maxGuesses" value="<?php echo $_SESSION['maxGuesses'] ?>" required>
        </div>

        <div class="mb-3 flex-fill">
            <label for="timePerGuess" class="form-label">Time per guess (s)</label>
            <input type="number" class="form-control" name="timePerGuess" value="<?php echo $_SESSION['timePerGuess'] ?>" required>
        </div>
    </div>

    <div class="d-grid">
        <input type="hidden" name="action" value="start">
        <button type="submit" class="btn btn-primary btn-lg">
            Start Game
        </button>
    </div>
</form>
