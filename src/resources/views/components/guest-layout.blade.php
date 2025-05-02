<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <main class="w-full max-w-md p-6 bg-white shadow-md rounded">
        {{ $slot }}
    </main>
</body>

</html>