<!DOCTYPE html>
<html>
<head>
    <title>LOGIN PAGE</title>
</head>
<body>
<h2>Login</h2>
<form id="loginForm">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
</form>
<p id="loginMsg"></p>
<p><a href="/forgot">Forgot Password?</a></p>
<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const data = new FormData(form);
    fetch('/login', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(response => {
        if (response.includes('dashboard')) {
            window.location.href = '/dashboard';
        } else {
            document.getElementById('loginMsg').innerText = response;
        }
    });
});
</script>
</body>
</html>
