<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>News Management</title>
</head>
<body>
<h1>News Management</h1>
<?php

use App\Helpers\BaseHelper;

$currentUser = BaseHelper::getUser();
?>
<p>Logged in: <?= htmlspecialchars($currentUser ?? '') ?> | <a href="/logout.php">Logout</a></p>

<h2>Create New News</h2>
<form id="newsForm">
    <input type="hidden" name="id" id="newsId">
    <input type="text" name="title" id="newsTitle" placeholder="Title" required><br>
    <textarea name="body" id="newsBody" placeholder="Content" required></textarea><br>
    <button type="submit">Save</button>
</form>

<h2>News List</h2>
<ul id="newsList"></ul>

<script src="assets/app.js"></script>
</body>
</html>
