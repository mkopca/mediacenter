<!DOCTYPE html>
<html>
<head>
    <title>Google Drive Files</title>
</head>
<body>
<h1>Files on Google Drive</h1>
<ul>
    @foreach ($files as $file)
        <li>{{ dd($file) }}</li>
    @endforeach
</ul>
</body>
</html>
