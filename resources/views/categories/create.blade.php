<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Item</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; padding: 2rem; max-width: 600px; margin: 0 auto; color: #333; }
        h1 { font-size: 1.5rem; font-weight: 500; margin-bottom: 2rem; }
        a { color: #000; text-decoration: none; }
        a:hover { text-decoration: underline; }
        form { display: flex; flex-direction: column; gap: 1.5rem; }
        label { font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem; display: block; }
        input, textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem; font-family: inherit; }
        input:focus, textarea:focus { outline: none; border-color: #999; }
        textarea { resize: vertical; min-height: 100px; }
        .buttons { display: flex; gap: 1rem; margin-top: 1rem; }
        button { padding: 0.75rem 1.5rem; border: 1px solid #000; background: #000; color: #fff; border-radius: 4px; cursor: pointer; font-size: 0.875rem; }
        button:hover { background: #333; }
        .btn-secondary { background: #fff; color: #000; border: 1px solid #ddd; }
        .btn-secondary:hover { background: #f5f5f5; }
    </style>
</head>
<body>
    <h1>Create New Item</h1>

    <form action="{{ route('items.store') }}" method="POST">
        @csrf
        
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description"></textarea>
        </div>

        <div class="buttons">
            <button type="submit">Create</button>
            <a href="{{ route('items.index') }}" class="btn-secondary" style="padding: 0.75rem 1.5rem; display: inline-block; border-radius: 4px; border: 1px solid #ddd;">Cancel</a>
        </div>
    </form>
</body>
</html>