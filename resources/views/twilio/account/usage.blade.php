@php
    use Cknow\Money\Money;
@endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
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
                <tfoot>
                <tr>
                    <td colspan="4">
                        @if($recordCount)
                            {{ $recordCount }} record{{ ($recordCount > 1) ? 's' : '' }} available.
                        @else
                            No records available
                        @endif
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</main>
<footer>
    <section>
        &copy; Twilio {{ date('Y') }}.
        Designed and developed by <a href="https://matthewsetter.com"
                                     target="_blank"
                                     class="underline underline-offset-2 decoration-2 decoration-indigo-700">Matthew Setter</a>.
    </section>
</footer>
</body>
</html>
