<!DOCTYPE html>
<html>
<head>
    <title>New Company Created</title>
</head>
<body>
    <h1>Company Created Successfully!</h1>
    <p>We are happy to inform you that a new company has been successfully created:</p>

    <table>
        <tr><td><strong>Name:</strong></td><td>{{ $company->name }}</td></tr>
        <tr><td><strong>Email:</strong></td><td>{{ $company->email }}</td></tr>
        <tr><td><strong>Website:</strong></td><td>{{ $company->website }}</td></tr>
    </table>

    <p>Thank you for using our application!</p>
</body>
</html>
