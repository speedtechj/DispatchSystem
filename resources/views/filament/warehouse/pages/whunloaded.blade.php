<x-filament-panels::page>
    {{ $this->form }}
    @if ($scannedInvoices)
        <div class="">
            <div
                class="rounded-lg bg-gray-50 shadow-xs outline-1 outline-gray-900/5 dark:bg-gray-800/50 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
                <dl class="flex flex-wrap">
                    <div class="flex-auto pt-6 pl-6">
                        <dt class="text-lg font-semibold text-gray-900 dark:text-gray-100">Invoice Number</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $scannedInvoices->invoice->invoice ?? null }}</dd>
                    </div>

                    <div
                        class="mt-6 flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-6 dark:border-white/5">
                        <dt class="flex-none">
                            Sender
                        </dt>
                        <dd class="text-sm/6 font-medium text-gray-900 dark:text-white">
                            {{ $scannedInvoices->invoice->sender_name }}</dd>
                    </div>
                    <div
                        class="mt-6 flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-2 dark:border-white/5">
                        <dt class="flex-none">
                            Receiver
                        </dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ $scannedInvoices->invoice->receiver_name }}</dd>
                    </div>
                    <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
                        <dt class="flex-none">
                            Address

                        </dt>
                        <dd class="text-lg text-gray-500 dark:text-gray-300">
                            {{ $scannedInvoices->invoice->receiver_address }}</br>
                        </dd>
                    </div>
                    <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
                        <dt class="flex-none">
                            Barangay

                        </dt>
                        <dd class="text-lg text-gray-500 dark:text-gray-300">
                            {{ $scannedInvoices->invoice->receiver_barangay }}
                        </dd>
                    </div>
                    <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
                        <dt class="flex-none">
                            City
                        </dt>
                        <dd class="text-lg text-gray-500 dark:text-gray-300">
                            {{ $scannedInvoices->invoice->receiver_city }}
                        </dd>
                    </div>
                    <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
                        <dt class="flex-none">
                            Province
                        </dt>
                        <dd class="text-lg text-gray-500 dark:text-gray-300">
                            {{ $scannedInvoices->invoice->receiver_province }}
                        </dd>
                    </div>
                    <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
                        <dt class="flex-none">
                            Box Type
                        </dt>
                        <dd class="text-lg text-gray-500 dark:text-gray-300">
                            {{ $scannedInvoices->invoice->boxtype }}
                        </dd>
                    </div>
                </dl>
                <div class="mt-2 border-t border-gray-900/5 px-6 py-2 dark:border-white/5">

                    <div class="mt-2 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">
                                                Invoice</th>
                                            <th scope="col"
                                                class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">
                                                Sender</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                Receiver</th>
                                             <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                Trip Number</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                Box Type</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                Unloaded</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                                        @foreach ($customerinfos as $customerinfo)
                                            <tr>
                                                <td
                                                    class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0 dark:text-white">
                                                    {{ $customerinfo->invoice }}</td>
                                                <td
                                                    class="py-4  text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0 dark:text-white">
                                                    {{ $customerinfo->sender_name }}</td>
                                                <td
                                                    class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                    {{ $customerinfo->receiver_name }}
                                                </td>
                                                <td
                                                    class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                    {{ $customerinfo->whtripinvoice->whdeliverylog->trip_number ?? 'No Trip Number'}}
                                                </td>
                                                <td
                                                    class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                    {{ $customerinfo->boxtype }}


                                                </td>
                                                <td
                                                    class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                    {{-- {{ $customerinfo->whtripinvoice->is_unloaded}} --}}
                                                    @if ($customerinfo->whtripinvoice?->is_unloaded)
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-6 text-green-500">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-6 text-red-500">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                        </svg>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
</x-filament-panels::page>
