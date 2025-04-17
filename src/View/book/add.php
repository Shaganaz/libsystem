<!DOCTYPE html>
<html>
    <head>
        <title>ADD BOOKS</title>
    </head>
    <body>
        <h1>Add a new book</h1>
        <form id="addBookForm">
        <label>Title: <input type="text" name="title" required</label><br><br>
        <label>Author: <input type="text" name="author" required</label><br><br>
        <button type="submit">Add Book</button>
</form>
<p id="message"></p>
<script>
    document.getElementById('addBookForm').onsubmit=async function (e) {
        e.preventDefault();
        const formData=new FormData(this);
        const response=await fetch('books/save',{
            method:'POST',
            body: formData
        });
        const message=document.getElementById('message');
        message.textContent=response.ok ? 'Book addded succcesssfully' : 'Error adding book';

        if(response.ok) this.reset();
    };
</script>
    </body>
</html>