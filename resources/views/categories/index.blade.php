<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; padding: 2rem; max-width: 800px; margin: 0 auto; color: #333; }
        h1 { font-size: 1.5rem; font-weight: 500; margin-bottom: 2rem; }
        a { color: #000; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .btn { display: inline-block; padding: 0.5rem 1rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.875rem; }
        .btn:hover { background: #f5f5f5; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.75rem; text-align: left; border-bottom: 1px solid #eee; }
        th { font-weight: 500; font-size: 0.875rem; color: #666; }
        td { font-size: 0.9rem; }
        .actions { display: flex; gap: 1rem; }
    </style>
</head>
<body>
    <h1>Items</h1>
    
    <a href="{{ route('items.create') }}" class="btn">New Item</a>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->description }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('items.show', $item) }}">View</a>
                        <a href="{{ route('items.edit', $item) }}">Edit</a>
                        <form action="{{ route('items.destroy', $item) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; color: #000; cursor: pointer; font-size: 0.9rem;">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>