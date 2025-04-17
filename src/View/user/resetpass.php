<!DOCTYPE html>
<html>
<head>
    <title>RESET PASSWORD</title>
</head>
<body>
<h2>Reset Password</h2>
<form id="resetForm">
    <input type="hidden" name="token" value="<?php echo $_GET['token'] ?? ''; ?>">
    <label>New Password:</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">Reset Password</button>
</form>
<p id="resetMsg"></p>
<script>
document.getElementById('resetForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const data = new FormData(form);
    fetch('/reset', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(response => {
        document.getElementById('resetMsg').innerText = response;
    });
});
</script>
</body>
</html>
