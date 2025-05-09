<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $liste->nom }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #967259;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #967259;
            margin: 0;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .tea-count {
            text-align: center;
            background-color: #967259;
            color: white;
            padding: 10px;
            margin: 20px 0;
        }
        .tea-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .tea-card {
            border: 1px solid #ddd;
            padding: 15px;
            background-color: #F4E5C3;
            border-radius: 5px;
        }
        .tea-card h3 {
            margin: 0 0 10px 0;
            color: #4A3428;
        }
        .tea-card p {
            margin: 5px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $liste->nom }}</h1>
        <p>Créée le {{ $liste->date_creation->format('d/m/Y') }}</p>
    </div>

    <div class="tea-count">
        <h2>{{ $liste->thes->count() }} Thés</h2>
    </div>

    <div class="tea-grid">
        @foreach($liste->thes as $the)
            <div class="tea-card">
                <h3>{{ $the->nom }}</h3>
                <p><strong>Type:</strong> {{ $the->type->nom }}</p>
                <p><strong>Provenance:</strong> {{ $the->provenance->nom }}</p>
                <p><strong>Variété:</strong> {{ $the->variete->nom }}</p>
            </div>
        @endforeach
    </div>
</body>
</html>