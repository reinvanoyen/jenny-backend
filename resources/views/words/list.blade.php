<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Vetpot</title>
</head>
<body style="background-color: #412f25;">
@foreach($words as $word)
    <div style="color: white;">
        {{ $word->word }} (Reting: {{ $word->rating }}) – {{ $word->author ? $word->author->name : 'anoniempje' }}
    </div>
@endforeach
</body>
</html>
