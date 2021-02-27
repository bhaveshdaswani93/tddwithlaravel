<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Project</title>
</head>

<body>
    <form method="post" action="/projects">
        @csrf
        <input name="title" required />
        <input name="description" required />
        <button>Submit</button>
    </form>

</body>

</html>