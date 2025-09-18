<!DOCTYPE html>
<html>
<head>
    <title>Hírek kezelése</title>
</head>
<body>
<h1>Hírek kezelése</h1>
<p>Bejelentkezve: <?= htmlspecialchars($this->user) ?> | <a href="/logout.php">Kilépés</a></p>

<h2>Új hír</h2>
<form id="newsForm">
    <input type="hidden" name="id" id="newsId">
    <input type="text" name="title" id="newsTitle" placeholder="Cím" required><br>
    <textarea name="body" id="newsBody" placeholder="Szöveg" required></textarea><br>
    <button type="submit">Mentés</button>
</form>

<h2>Hírek</h2>
<ul id="newsList"></ul>

<script src="assets/app.js"></script>
</body>
</html>
