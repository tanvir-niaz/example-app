<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/register" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Name">
        <input type="email" name="email" placeholder="email">
        <input type="password"  name="password" placeholder="password">
        <button>Submit</button>
    </form>
    {{-- <form action="/signin" method="POST">
        @csrf
        <input type="email" name="email" placeholder="email">
        <input type="password"  name="password" placeholder="password">
        <button>Submit</button>
    </form> --}}
</body>
</html>