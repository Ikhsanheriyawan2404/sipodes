<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Data</title>
</head>
<body>
    <form action="{{ route('wisata.store') }}" method="post">
        @csrf
        <input type="text" name="title">
        <input type="text" name="description">
        <button type="submit">Save</button>
    </form>
</body>
</html>
