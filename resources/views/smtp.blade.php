<!DOCTYPE html>
<html>
<head>
    <title>Create SMTP</title>
</head>
<body>
    <h1>Add SMTP</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form action="{{ route('smtp.store') }}" method="POST">
        @csrf
        <label>MAIL_MAILER:</label>
        <input type="text" name="mailer" value="smtp"><br>

        <label>MAIL_HOST:</label>
        <input type="text" name="host"><br>

        <label>MAIL_PORT:</label>
        <input type="number" name="port"><br>

        <label>MAIL_USERNAME:</label>
        <input type="text" name="username"><br>

        <label>MAIL_PASSWORD:</label>
        <input type="text" name="password"><br>

        <label>MAIL_ENCRYPTION:</label>
        <input type="text" name="encryption" value="tls"><br>

        <label>MAIL_FROM_ADDRESS:</label>
        <input type="email" name="from_address"><br>

        <label>MAIL_FROM_NAME:</label>
        <input type="text" name="from_name"><br>

        <label>LIMIT:</label>
        <input type="number" name="limit" value="300"><br><br>

        <button type="submit">Save SMTP</button>
    </form>
</body>
</html>
