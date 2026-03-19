<?php
session_start();
function init()
{
    if(!isset($_SESSION['gameStarted']))
    {
        $_SESSION['gameStarted'] = false;
        $_SESSION['guesses'] = [];
        $_SESSION['secretNumber'] = null;
        $_SESSION['min'] = 1;
        $_SESSION['max'] = 100;
    }
}

function handleRequest() {
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if(isset($_POST['action']))
        {
            switch($_POST['action'])
            {
                case 'start':
                    handleStart();
                    break;
                case 'guess':
                    handleGuess();
                    break;
                case 'reset':
                    handleReset();
                    break;
            }
        }
    }
}

function handleStart()
{
    $min = (int)$_POST['min'];
    $max = (int)$_POST['max'];
    
    // Validate input
    if($min >= $max)
    {
        return; // Don't start if invalid
    }
    
    // Store range and generate secret number
    $_SESSION['min'] = $min;
    $_SESSION['max'] = $max;
    $_SESSION['secretNumber'] = mt_rand($min, $max);
    $_SESSION['guesses'] = [];
    $_SESSION['gameStarted'] = true;
}

function handleGuess()
{
    $guess = (int)$_POST['guess'];
    $secret = $_SESSION['secretNumber'];
    
    // Add guess to history
    $_SESSION['guesses'][] = $guess;
    
    // Check the guess
    if($guess < $secret)
    {
        $_SESSION['message'] = "Your guess is TOO LOW!";
    }
    elseif($guess > $secret)
    {
        $_SESSION['message'] = "Your guess is TOO HIGH!";
    }
    else
    {
        $_SESSION['message'] = "CORRECT! The secret number was " . $secret . "!";
        $_SESSION['gameStarted'] = false; // End the game
    }
}

function handleReset() {
    $_SESSION['gameStarted'] = false;
    unset($_SESSION['secretNumber']);
    unset($_SESSION['guesses']);
    unset($_SESSION['message']);
}

function startForm()
{
    ?>
    <div class="form-container">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="game-form">
            <fieldset>
                <legend>Set Your Game Range</legend>
                
                <div class="form-group">
                    <label for="min">Minimum Value:</label>
                    <input type="number" name="min" id="min" placeholder="e.g., 1" value="1" required>
                </div>
                
                <div class="form-group">
                    <label for="max">Maximum Value:</label>
                    <input type="number" name="max" id="max" placeholder="e.g., 100" value="100" required>
                </div>
                
                <input type="hidden" name="action" value="start">
                <button type="submit" class="btn btn-primary" value="start">Start Game</button>
            </fieldset>
        </form>
    </div>
    <?php
}

function gameForm()
{
    ?>
    <div class="form-container">
        <?php if(isset($_SESSION['message'])): ?>
            <div class="message">
                <h3><?php echo htmlspecialchars($_SESSION['message']); ?></h3>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        <div class="game-info">
            <p class="range-display">
                Guess a number between <strong><?php echo $_SESSION['min']; ?></strong> 
                and <strong><?php echo $_SESSION['max']; ?></strong>
            </p>
        </div>
        
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="game-form">
            <input type="hidden" name="action" value="guess">
            
            <div class="form-group">
                <label for="guess">Your Guess:</label>
                <input 
                    type="number" 
                    name="guess" 
                    id="guess" 
                    placeholder="Enter your guess" 
                    min="<?php echo $_SESSION['min']; ?>" 
                    max="<?php echo $_SESSION['max']; ?>" 
                    required
                    autofocus
                >
            </div>
            
            <button type="submit" class="btn btn-primary">Make Guess</button>
        </form>
        
        <?php if(!empty($_SESSION['guesses'])): ?>
            <div class="guesses-history">
                <h3>Your Guesses (<?php echo count($_SESSION['guesses']); ?> total):</h3>
                <p><?php echo implode(', ', $_SESSION['guesses']); ?></p>
            </div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="reset-form">
            <input type="hidden" name="action" value="reset">
            <button type="submit" class="btn btn-secondary" value="reset">Reset Game</button>
        </form>
    </div>
    <?php
}

function reload($location = null, $statusCode = 302, $exitAfter = true)
{
    // Bepaal de locatie om naar toe te sturen
    if ($location === null || $location === '')
    {
        $location = $_SERVER['PHP_SELF'];
    }

    // Als alleen een query string is opgegeven, voeg deze dan toe aan het huidige script
    if (strpos($location, '?') === 0)
    {
        $location = $_SERVER['PHP_SELF'] . $location;
    }

    header(sprintf('Location: %s', $location), true, $statusCode);

    if ($exitAfter)
    {
        exit();
    }
}

function gameStarted() {
    return $_SESSION['gameStarted'] === true;
}

function head() {
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- add stylesheets -->
        <!-- link to Bootstrap CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/stylesheet.css">
        <title>Home</title>
    </head>
    <?php
}

function respond($type = 'info', $message)
{
    $_SESSION['response'] = ['message' => $message, 'type' => $type];
}

function dump($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}