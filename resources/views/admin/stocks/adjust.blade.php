<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>ttle : {{ $product->title }}</h1>
        <p>description : {{ $product->description }}</p>
        <p>price : {{ $product->price }} $</p>
    </div>
    <form action="{{ route('admin.stock.adjust',$product) }}" method="post">
        @csrf
        @method('PATCH')
        <input type="number" name="quantity" id="quantity" value="{{ $product->quantity }}">
        <input type="number" name="stock_alert_threshold" id="tock_alert_threshol" value="{{ $product->stock_alert_threshold }}">
        <button type="submit">Add quantity stock</button>
    </form>
</body>
</html>