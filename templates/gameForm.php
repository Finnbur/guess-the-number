<?php
// TODO: change this to be at a better place
if (time() - $_SESSION['time'] >= $_SESSION['timePerGuess']) {
    $_SESSION['gameWon'] = false;
    reload();
}

$remaining = $_SESSION['timePerGuess'] - (time() - $_SESSION['time']);
$remaining = max(0, min($_SESSION['timePerGuess'], $remaining));
$percentage = ($remaining / $_SESSION['timePerGuess']) * 100;
?>

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

    <div class="row align-items-center mb-4 g-3">
        <!-- amount of guesses left -->
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

        <!-- Time Left -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Time Left</span>
                    <span id="timeText" class="badge <?php echo $percentage < 30 ? 'bg-danger' : ($percentage < 60 ? 'bg-warning' : 'bg-success'); ?> fs-6">
                        <?php echo $remaining; ?>s
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="progress mb-4" style="height: 25px;">
        <div id="progressBar"
            class="progress-bar progress-bar-striped progress-bar-animated 
            <?php echo $percentage < 30 ? 'bg-danger' : ($percentage < 60 ? 'bg-warning' : 'bg-success'); ?>"
            role="progressbar"
            style="width: <?php echo $percentage; ?>%">
        </div>
    </div>

    <!-- guess reset and play again buttons -->
    <div class="input-group input-group-lg mb-1">
        <input type="number" class="form-control" id="guess" name="guess" placeholder="Guess here..." required autofocus>
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

    <?php require_once 'partials/guessesList.php'; ?>
    <script>
        let totalTime = <?php echo $_SESSION['timePerGuess']; ?>;
        let remaining = <?php echo $remaining; ?>;
    </script>
</form>

<script>
    let interval = setInterval(() => {
        remaining--;

        if (remaining <= 0) {
            remaining = 0;
            clearInterval(interval);
            location.reload(); // reload when time is up
        }

        let percentage = (remaining / totalTime) * 100;

        // Update text
        document.getElementById("timeText").innerText = remaining + "s";

        // Update bar width
        let bar = document.getElementById("progressBar");
        bar.style.width = percentage + "%";

        // Update color dynamically
        bar.classList.remove("bg-success", "bg-warning", "bg-danger");
        document.getElementById("timeText").classList.remove("bg-success", "bg-warning", "bg-danger");

        if (percentage < 30) {
            bar.classList.add("bg-danger");
            document.getElementById("timeText").classList.add("bg-danger");
        } else if (percentage < 60) {
            bar.classList.add("bg-warning");
            document.getElementById("timeText").classList.add("bg-warning");
        } else {
            bar.classList.add("bg-success");
            document.getElementById("timeText").classList.add("bg-success");
        }

    }, 1000);
</script>