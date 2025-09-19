<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h1>Bejelentkezés</h1>
<?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
</body>
</html>
