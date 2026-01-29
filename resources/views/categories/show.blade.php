<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Item</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; padding: 2rem; max-width: 600px; margin: 0 auto; color: #333; }
        h1 { font-size: 1.5rem; font-weight: 500; margin-bottom: 2rem; }
        a { color: #000; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .field { margin-bottom: 1.5rem; }
        .label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #666; margin-bottom: 0.5rem; }
        .value { font-size: 1rem; line-height: 1.5; }
        .buttons { display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee; }
        .btn { padding: 0.5rem 1rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.875rem; display: inline-block; }
        .btn:hover { background: #f5f5f5; }
    </style>
</head>
<body>
    <h1>{{ $item->name }}</h1>

    <div class="field">
        <div class="label">Description</div>
        <div class="value">{{ $item->description ?? 'No description' }}</div>
    </div>

    <div class="buttons">
        <a href="{{ route('items.index') }}" class="btn">Back</a>
        <a href="{{ route('items.edit', $item) }}" class="btn">Edit</a>
    </div>
</body>
</html>