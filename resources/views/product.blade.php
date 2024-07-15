<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product List</title>
    <style>
        /* Basic styling for demonstration purposes */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center; /* Center items vertically */
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0; /* Remove default margin */
        }
        .header button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        /* Styles for popup form */
        .popup-form {
            display: none; /* Initially hidden */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .overlay {
            display: none; /* Initially hidden */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Product List</h2>
        <button id="createProductBtn">Create Product</button>
    </div>

    <div id="popupForm" class="popup-form">
        <h2>Create Product</h2>
        <form action="/product" method="POST">
            @csrf
            <label for="name">Product Name:</label><br>
            <input id="name" name="name" required><br><br>
            
            <label for="price">Product Price:</label><br>
            <input  id="price" name="price" required><br><br>
            
            <label for="quantity">Product Quantity:</label><br>
            <input  id="quantity" name="quantity" required><br><br>
            
            <label for="discount">Product Discount:</label><br>
            <input id="discount" name="discount"><br><br>
            
            <button type="submit">Submit</button>
            <button type="button" onclick="closePopup()">Cancel</button>
        </form>
    </div>

    <div id="overlay" class="overlay"></div>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product Quantity</th>
                <th>Product Discount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>${{ $product->price }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->discount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
      {{$products->links()}}
    <script>
        var popup = document.getElementById('popupForm');
        var overlay = document.getElementById('overlay');
        var btn = document.getElementById("createProductBtn");
        
        btn.onclick = function() {
            popup.style.display = "block";
            overlay.style.display = "block";
        }

        function closePopup() {
            popup.style.display = "none";
            overlay.style.display = "none";
        }
    </script>
</body>
</html>
