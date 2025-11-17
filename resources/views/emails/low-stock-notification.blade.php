<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Alert</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; border-radius: 5px; padding: 20px; margin-bottom: 20px;">
        <h1 style="color: #dc3545; margin-top: 0;">⚠️ Low Stock Alert</h1>
    </div>

    <div style="background-color: #ffffff; border: 1px solid #dee2e6; border-radius: 5px; padding: 20px;">
        <p style="font-size: 16px; margin-bottom: 20px;">
            The following product is running low on stock and needs your attention:
        </p>

        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <h2 style="margin-top: 0; color: #495057;">{{ $product->name }}</h2>
            
            <div style="margin-bottom: 10px;">
                <strong>Current Stock:</strong> 
                <span style="color: #dc3545; font-size: 18px; font-weight: bold;">{{ $product->stock_quantity }}</span> units
            </div>

            <div style="margin-bottom: 10px;">
                <strong>Price:</strong> ${{ number_format($product->price, 2) }}
            </div>

            @if($product->description)
            <div style="margin-bottom: 10px;">
                <strong>Description:</strong> {{ $product->description }}
            </div>
            @endif

            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                <strong>Notification Time:</strong> {{ $timestamp }}
            </div>
        </div>

        <p style="color: #6c757d; font-size: 14px; margin-top: 20px;">
            Please restock this product as soon as possible to avoid running out of inventory.
        </p>
    </div>

    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #dee2e6; text-align: center; color: #6c757d; font-size: 12px;">
        <p>This is an automated notification from your E-commerce Shopping Cart system.</p>
    </div>
</body>
</html>

