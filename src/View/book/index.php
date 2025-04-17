<!DOCTYPE html>
<html>
<head>
    <title>LIBRARY BOOKS</title>
</head>
<body>
    <h1>All Books</h1>

    <a href="/books/create">Add Book</a>

    <input type="text" id="search" placeholder="Search books..." />

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="book-list">
            <?php if (!empty($books)) : ?>
                <?php foreach ($books as $book) : ?>
                    <tr id="row-<?= $book['id'] ?>">
                        <td><?= $book['id'] ?></td>
                        <td><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td>
                            <button onclick="deleteBook(<?= $book['id'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="4">No books found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        async function deleteBook(id) {
            if (confirm("Are you sure you want to delete this book?")) {
                const res = await fetch(`/books/delete/${id}`, { method: 'GET' });
                if (res.ok) {
                    const row = document.getElementById(`row-${id}`);
                    if (row) row.remove();
                }
            }
        }

        document.getElementById('search').addEventListener('input', async function () {
            const query = this.value.trim();
            if (query.length < 2) return;

            const res = await fetch('/books/search?term=' + encodeURIComponent(query));
            const books = await res.json();
            const table = document.getElementById('book-list');
            table.innerHTML = '';  // Clear current rows

            books.forEach(book => {
                const row = `<tr id="row-${book.id}">
                    <td>${book.id}</td>
                    <td>${book.title}</td>
                    <td>${book.author}</td>
                    <td><button onclick="deleteBook(${book.id})">Delete</button></td>
                </tr>`;
                table.innerHTML += row;
            });
        });
    </script>
</body>
</html>
