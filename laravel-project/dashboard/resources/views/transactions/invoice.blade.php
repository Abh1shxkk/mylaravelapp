<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $payment->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-3xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Invoice</h1>
            <div class="space-x-2">
                <a href="{{ route('transactions.index') }}" class="px-4 py-2 rounded border hover:bg-gray-50">Back</a>
                <button onclick="window.print()" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Print / Save PDF</button>
            </div>
        </div>

        @include('transactions._invoice_card', ['payment' => $payment])
    </div>
</body>
</html>
