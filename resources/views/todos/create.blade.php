<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Todos</title>
</head>
<body>
    <div class="text-center pt-10">
        <h1 class="text-2xl">What next you need To-Do</h1>
        <x-alert/>
        <form action="/todos/create" method="POST" enctype="multipart/form-data" class="py-5">
            @csrf   <!-- this @csrf token handles routes in form -->
            <input type="text" name="title" class="py-2 px-2 border"/>
            <input type="submit" value="Create" class="p-2 border rounded"/>
        </form> 
    </div>
</body>
</html>