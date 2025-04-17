<!DOCTYPE html>
<html>
    <head>
        <title>EDIT BOOK</title>
    </head>
    <body>
        <h2>Edit book</h2>
        <form id="editBookForm">
        <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required><br>
        <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required><br>
        <button type="submit">Update Book</button>
</form>
<div id="message"></div>
<script>
    document.getElementById('editBookForm').onsubmit=async function (e) {
        e.preventDefault();
        const formData=new FormData(this);
        const response=await fetch('books/update/<?= $book['id'] ?>', {
            method:'POST',
            body: formData
        });
        const message=document.getElementById('message');
        message.textContent=response.ok ? 'Updated' : 'Update failed';

        
    };
</script>
    </body>
</html>