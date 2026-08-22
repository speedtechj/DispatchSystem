<x-filament::page>
    {{ $this->form }}

    @if ($scannedInvoices)
        <div class="text-shadow-lg divide-y divide-gray-200 overflow-hidden rounded-lg bg-gray-100 shadow-sm dark:divide-white/10 dark:bg-gray-800/50 dark:shadow-none dark:outline dark:-outline-offset-1 dark:outline-white/10">


        <div class="text-shadow-lg px-4 py-5 sm:px-6 lg:text-2xl md:text-lg">
            <div>Invoice - {{ $scannedInvoices->invoice }}</div>
        </div>
        <div class="px-4 py-5 sm:px-6 lg:text-2xl md:text-lg">
            <div>Sender - {{ $scannedInvoices->sender_name }}</div>
        </div>
        <div class="text-shadow-lg px-4 py-5 sm:p-6 lg:text-2xl md:text-lg">
            <div>Receiver - {{ $scannedInvoices->receiver_name }}</div>
            <div>Address - {{ $scannedInvoices->receiver_address }}</div>
            <div>Barangay - {{ $scannedInvoices->receiver_barangay }}</div>
            <div>City - {{ $scannedInvoices->receiver_city }}</div>
            <div>Province - {{ $scannedInvoices->receiver_province }}</div>
            <div>Box Type - {{ $scannedInvoices->boxtype }}</div>
        </div>

</div>

    @endif
</x-filament::page>
