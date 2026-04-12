<h3>Start Game</h3>
<p class="text-muted small mb-4">Login to save scores</p>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    
    <div class="d-flex gap-2 mb-2">
        <div class="col-6 flex-fill">
            <label for="gamemode" class="form-label">Game Mode</label>
            <select class="form-select" name="gamemode" id="gamemode">
                <option value="basic" <?php echo $_SESSION['gamemode'] == 'basic' ? 'selected' : ''; ?>>Basic</option>
                <option value="rush" <?php echo $_SESSION['gamemode'] == 'rush' ? 'selected' : ''; ?>>Rush</option>
            </select>
        </div>

        <div class="col-6 flex-fill">
            <label for="difficulty" class="form-label">Difficulty</label>
            <select class="form-select" name="difficulty" id="difficulty">
                <option value="custom" <?php echo $_SESSION['difficulty'] == 'custom' ? 'selected' : ''; ?>>Choose own</option>
                <option value="easy" <?php echo $_SESSION['difficulty'] == 'easy' ? 'selected' : ''; ?>>Easy (1 - 10)</option>
                <option value="normal" <?php echo $_SESSION['difficulty'] == 'normal' ? 'selected' : ''; ?>>Normal (1 - 50)</option>
                <option value="hard" <?php echo $_SESSION['difficulty'] == 'hard' ? 'selected' : ''; ?>>Hard (1 - 100)</option>
            </select>
        </div>
    </div>

    <div class="d-flex gap-2 mb-2">
        <div class="flex-fill">
            <label for="min" class="form-label">Minimum Number</label>
            <input type="number" class="form-control" name="min" id="minNum" min="1" value="<?php echo $_SESSION['min'] ?>" required>
        </div>

        <div class="flex-fill">
            <label for="max" class="form-label">Maximum Number</label>
            <input type="number" class="form-control" name="max" id="maxNum" min="2" value="<?php echo $_SESSION['max'] ?>" required>
        </div>
    </div>

    <div class="d-flex gap-2 mb-3">
        <div class="flex-fill">
            <label for="maxGuesses" class="form-label">Maximum Guesses</label>
            <input type="number" class="form-control" name="maxGuesses" min="1" value="<?php echo $_SESSION['maxGuesses'] ?>" required>
        </div>

        <div class="flex-fill">
            <label for="gameTime" class="form-label">Game time (s)</label>
            <input type="number" class="form-control" name="gameTime" min="1" value="<?php echo $_SESSION['gameTime'] ?>" required>
        </div>
    </div>

    <div class="d-grid">
        <input type="hidden" name="action" value="start">
        <button type="submit" class="btn btn-primary btn-lg">
            Start Game
        </button>
    </div>
</form>