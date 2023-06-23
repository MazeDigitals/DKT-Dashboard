<x-mail::message>
    <p>Dear {{$name}},</p>
    <p>Congratulations! You have won bid amount {{$bid_amount}} of Product: {{$product_name}}</p>
    <p>You will be contacted by admin soon.</p>
    <p>Thank you.</p>
    <strong>{{ env('APP_NAME') }}</strong>
</x-mail::message>
