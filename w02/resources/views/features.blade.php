<!DOCTYPE html>
<html>
<head>
    <title>Features</title>
</head>
<body>
    <h2>Laravel Features</h2>

    <ul>
        @foreach ($features as $feature)
            <li>{{ $feature }}</li>
        @endforeach
    </ul>
</body>
</html>
