<!DOCTYPE html>
<html>

<head>
    <title>Продукты</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<style type="text/css">
    h2 {
        text-align: center;
        font-size: 22px;
        margin-bottom: 50px;
    }

    body {
        background: #f2f2f2;
    }

    .section {
        margin-top: 150px;
        padding: 50px;
        background: #fff;
    }
</style>

<body>
<div>
    <h2>Продукты</h2>

    <table class="table">
        <thead>
        <tr>
            @foreach (\App\Models\Product::getCaptions() as $caption)
                <th>{{ $caption }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody class="table-group-divider">
        @foreach ($products as $product)
            <tr>
                @foreach (get_object_vars($product) as $value)
                    <td>{{ $value }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>

