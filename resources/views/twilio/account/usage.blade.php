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
<body>
<main>
    <div class="content-wrapper">
        <header>
            <div class="flex-auto">
                <h1 class="text-xl font-bold">{{ $title }}</h1>
                <p class="text-base mt-2">A list of your current account usage.</p>
            </div>
            <div class="flex-none mr-4 mt-3">
                <img src="/img/twilio-logo.svg"
                      alt="Twilio's logo"
                      class="w-12">
            </div>
        </header>

        <div id="usageTypeForm"></div>

        <div class="usage-records-wrapper">
            <table class="w-full" id="usageRecords">
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
