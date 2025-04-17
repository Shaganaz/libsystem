<!DOCTYPE html>
<html>
<head>
    <title>FORGOT PASSWORD</title>
</head>
<body>
<h2>Forgot Password</h2>
<form id="forgotForm">
    <label>Enter your email:</label><br>
    <input type="email" name="email" required><br><br>
    <button type="submit">Send Reset Link</button>
</form>
<p id="forgotMsg"></p>
<script>
document.getElementById('forgotForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const data = new FormData(form);
    fetch('/forgot', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(response => {
        document.getElementById('forgotMsg').innerText = response;
    });
});
</script>
</body>
</html>
