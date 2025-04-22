<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Books</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .top-bar input[type="text"] {
            padding: 10px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .top-bar button, .add-book-btn {
            background-color:#2563eb;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .top-bar button:hover, .add-book-btn:hover {
            background-color:#1e40af;
        }
        .add-book-btn {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color:#f1f5f9;
        }
        tr:hover {
            background-color:#f9fafc;
        }
        .no-books {
            text-align: center;
            padding: 20px;
            color: #999;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Library Book List</h2>
    <div class="top-bar">
        <form method="POST" action="/books">
            <input type="text" name="term" placeholder="Search books..." value="<?= htmlspecialchars($_GET['term'] ?? '') ?>">
            <button type="submit">Search</button>
        </form>
        <a href="/books/create">
            <button class="add-book-btn">+ Add New Book</button>
        </a>
    </div>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Book Name</th>
            <th>Author</th>
            <th>ISBN</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($books)): ?>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $book['id'] ?></td>
                    <td><?= htmlspecialchars($book['name']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= htmlspecialchars($book['isbn']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="no-books">No books found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
