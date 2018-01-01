<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Musti</title>
</head>
<body>
    <header>
        <h1><a href="/">Musti</a></h1>
    </header>
    <nav>
        <div class="col">
            <?php if (!isset($_SESSION['username'])): ?>
            <a href="register.php">Register</a>
            <?php else: ?>
            Connected as <?= $_SESSION['username']?>
            <?php endif; ?>
        </div>
        <div class="col">
            <?php if (isset($_SESSION['username'])): ?>
            <a href="logout.php">Logout</a>
            <?php else: ?>
            <a href="login.php">Login</a>
            <?php endif; ?>
        </div>
    </nav>
    <main>
        <?= $content ?>
    </main>
    <footer>
        <p>&copy; Neil Richter</p>
    </footer>
</body>
</html>