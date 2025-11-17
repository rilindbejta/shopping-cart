<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Sales Report</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 700px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; border-radius: 5px; padding: 20px; margin-bottom: 20px;">
        <h1 style="color: #28a745; margin-top: 0;">📊 Daily Sales Report</h1>
        <p style="color: #6c757d; margin-bottom: 0;">{{ $reportData['date'] }}</p>
    </div>

    <div style="background-color: #ffffff; border: 1px solid #dee2e6; border-radius: 5px; padding: 20px; margin-bottom: 20px;">
        <h2 style="margin-top: 0; color: #495057; border-bottom: 2px solid #28a745; padding-bottom: 10px;">Summary</h2>
        
        <div style="display: flex; flex-wrap: wrap; margin: -10px;">
            <div style="flex: 1; min-width: 150px; margin: 10px; padding: 15px; background-color: #e7f5ff; border-radius: 5px;">
                <div style="font-size: 14px; color: #6c757d;">Total Orders</div>
                <div style="font-size: 24px; font-weight: bold; color: #0056b3;">{{ $reportData['total_orders'] }}</div>
            </div>
            
            <div style="flex: 1; min-width: 150px; margin: 10px; padding: 15px; background-color: #d4edda; border-radius: 5px;">
                <div style="font-size: 14px; color: #6c757d;">Products Sold</div>
                <div style="font-size: 24px; font-weight: bold; color: #155724;">{{ $reportData['total_products_sold'] }}</div>
            </div>
            
            <div style="flex: 1; min-width: 150px; margin: 10px; padding: 15px; background-color: #fff3cd; border-radius: 5px;">
                <div style="font-size: 14px; color: #6c757d;">Total Revenue</div>
                <div style="font-size: 24px; font-weight: bold; color: #856404;">${{ number_format($reportData['total_revenue'], 2) }}</div>
            </div>
        </div>
    </div>

    @if(!empty($reportData['products_sold']))
    <div style="background-color: #ffffff; border: 1px solid #dee2e6; border-radius: 5px; padding: 20px;">
        <h2 style="margin-top: 0; color: #495057; border-bottom: 2px solid #28a745; padding-bottom: 10px;">Products Sold</h2>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr style="background-color: #f8f9fa;">
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Product Name</th>
                    <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Quantity</th>
                    <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData['products_sold'] as $product)
                <tr>
                    <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">{{ $product['name'] }}</td>
                    <td style="padding: 12px; text-align: center; border-bottom: 1px solid #dee2e6; font-weight: bold;">{{ $product['quantity'] }}</td>
                    <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6; color: #28a745; font-weight: bold;">${{ number_format($product['revenue'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 5px; padding: 20px; text-align: center;">
        <p style="color: #856404; margin: 0;">No sales recorded for this day.</p>
    </div>
    @endif

    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #dee2e6; text-align: center; color: #6c757d; font-size: 12px;">
        <p>This is an automated daily sales report from your E-commerce Shopping Cart system.</p>
        <p style="margin-top: 10px;">Generated at {{ now()->format('M d, Y h:i A') }}</p>
    </div>
</body>
</html>

