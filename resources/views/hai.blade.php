<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .container {
            text-align: center;
            background: #fff;
            padding: 80px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .message h1 {
            font-size: 2em;
            color: #333;
        }

        .message p {
            font-size: 1.2em;
            color: #666;
        }

        .illustration img {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">
            <h1>Hi, What are you looking for?</h1>
            <p>There is nothing you need on this page.</p>
        </div>
        <div class="illustration">
            <img src="{{ url('assets/images/others/404.svg') }}" class="img-fluid mb-2" alt="404">
        </div>
    </div>
</body>
</html>
