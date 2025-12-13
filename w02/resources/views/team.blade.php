<!DOCTYPE html>
<html>
<head>
    <title>Team</title>
</head>
<body>
    <h2>Our Team</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>Name</th>
            <th>Role</th>
        </tr>

        @foreach ($team as $member)
            <tr>
                <td>{{ $member['name'] }}</td>
                <td>{{ $member['role'] }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
