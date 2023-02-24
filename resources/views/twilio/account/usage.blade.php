@php
    use Cknow\Money\Money;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    @vite('resources/css/app.css')
</head>
<body class="antialiased">
<div
    class="relative sm:flex sm:flex-col sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    <div class="mt-16 px-0 sm:justify-between px-6 lg:px-0 w-full lg:w-3/4 lg:max-w-6xl">
        <h1 class="text-xl font-bold">Twilio Account Usage</h1>
        <p class="text-base mt-2">A list of your account usage for the last month.</p>
    </div>
    <div class="flex justify-center mt-8 sm:items-center sm:justify-between px-4 lg:px-0 w-full lg:w-3/4 lg:max-w-6xl">
        @if (count($usage_records))
            <table class="w-full">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Sent On</th>
                    <th>Qty</th>
                    <th>Amount</th>
                </tr>
                </thead>
                @foreach($usage_records as $record)
                    @php
                        $currency = \strtoupper($record->priceUnit);
                    @endphp
                    <tbody>
                    <tr>
                        <td class="font-bold">{{ $record->category }}</td>
                        <td>
                            <span class="hidden lg:block">{{ $record->startDate->format(env('DATE_FORMAT_LONG')) }}</span>
                            <span class="block lg:hidden">{{ $record->startDate->format(env('DATE_FORMAT_SHORT')) }}</span>
                        </td>
                        <td>{{ $record->count }}</td>
                        <td>{{ Money::$currency($record->price) }}</td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
        @endif
    </div>
</div>
</body>
</html>
