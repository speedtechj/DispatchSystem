<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $invoice->invoice}} Delivery Receipt</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-weight:bold;
            box-sizing: border-box;
        }

        .logo-left {
            width: 150px;
            height: 50px;
            margin: 0px;
            padding: 0px;
        }

        .logo-center {
            width: 150px;
            height: 50px;
            margin: 0px;
            padding: 0px;
        }

        .table-main,
        .table-inner {
            width: 100%;
            border-collapse: collapse;

        }

        .table-main td,
        .table-inner td {
            /* border: 1px solid #ccc;  */
            padding: 4px;
            text-align: left;
            /* vertical-align: top; */
            vertical-align: middle;
        }

        /* Inner table column widths */
        .table-inner.two-col td {
            font-size: 12px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            width: 50%;
        }

        .td-head {
            font-weight: bold;
            margin-bottom: 4px;
            /* space between head and content */
        }

        .table-inner.three-col td {
            vertical-align:top;
            width: 33.33%;
        }

        .table-inner.one-col td {
            color: red;
            width: 100%;
        }

        .half {
            width: 100;
            height: 50%;
            /* border: 1px solid #000; just to see the border */
            box-sizing: border-box;
            padding: 10px;
        }

        .cut-guide {
            /* position: absolute; */
            top: 50%;
            left: 0;
            width: 100%;
            border-top: 2px dashed #000;
            text-align: center;
            font-size: 12px;
            color: #555;
        }

        .page-container {
            width: 100%;
            /* set the desired page width */
            margin: 0 auto;
            /* horizontally center */
            background-color: #fff;
            position: relative;
            display: flex;
            flex-direction: column;
          /* //  padding-top: 5px; */
            /* optional padding */
        }

        .line {
            display: inline-block;
            width: 120px;
            /* set underline length */
            border-bottom: 1px solid #000;
            margin-left: 5px;
            text-align:left;
        }
    </style>
</head>

<body>

    
    <div class="page-container">
        <!-- section 1 -->
        <div class="half">
            <table class="table-main">

                <table class="table-inner three-col">
                    <td>
                        <img class="logo-left" src="{{ public_path('storage/'.$consolidator->logo) }}" alt="logo" /><br>
                        <span style="font-size:10!important;"> {{$consolidator->website }}<br>
                            {{ $consolidator->email }}<br>
                           {{$consolidator->mobile_no}}</span>
                    </td>
                    <td>
                        <img class="logo-center" src="{{ public_path('storage/logo/icargologo.png') }}"
                            alt="logo" /><br>
                       <span style="font-size:18px;font-weight:bold;">DELIVERY RECEIPT</span>
                    </td>
                    <td>
                        WWW.ICARGOXPRESS.NET<br>
                        Unit D, Riverside, Tanzang Luma VI, Imus City, Cavite 4103 Philippines <br>
                        +639178509815<br>
                        INQUIRIES@ICARGOXPRESS.COM
                    </td>
                    </tr>
                </table>

            </table>
            <table class="table-main">
                <tr>
                    <!-- First main td: split into 2 -->
                    <td>
                        <table class="table-inner two-col">
                            <tr>
                                <td class="td-head">SENDER INFORMATION</td>
                            </tr>
                        
                                <td>NAME<span style="text-align:center; margin-left:5px;border-bottom: 1px solid #000;">{{ $invoice->sender_name ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>TRACKING NO<span class="line">{{ $invoice->invoice ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>ORIGIN<span style="text-align:center; margin-left:5px;border-bottom: 1px solid #000;">{{$consolidator->company_name ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>BATCH NO<span class="line">{{ $invoice->batchno ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>BOX TYPE<span class="line">{{ $invoice->boxtype ?? '' }}</span> </td>
                            </tr>
                        </table>
                    </td>

                    <!-- Second main td: split into 2 -->
                    <td>
                        <table class="table-inner two-col">
                            <tr>
                                <td class="td-head">RECEIVER INFORMATION</td>
                            </tr>
                            <tr>
                                <td>NAME<span style="text-align:center; margin-left:5px;border-bottom: 1px solid #000;">{{ $invoice->receiver_name ?? '' }}</span></td>
                            </tr>               
                            <tr>
                                 <td colspan="2">ADDRESS<span style="text-align:center; margin-left:5px;border-bottom: 1px solid #000;">{{ $invoice->receiver_address ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>PROVINCE <span class="line">{{ $invoice->receiver_province ?? '' }}</span></td>
                                <td>CITY:<span class="line">{{ $invoice->receiver_city ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>BARANGAY<span style="text-align:center; margin-left:5px;border-bottom: 1px solid #000;">{{ $invoice->receiver_barangay ?? '' }}</span></td>
                                <td>POSTALCODE<span class="line">{{ $invoice->receiver_postalcode ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>EMAIL<span class="line">{{ $invoice->receiver_email ?? '' }}</span></td>
                                <td>PHONE <span class="line">{{ $invoice->receiver_mobile_no ?? '' }}</span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="table-main">
                <br>
                <span>Acknowledgement Receipt</span>
                <p style="text-align:justify;">
                    This is to formally acknowledge that I have received the box/item(s) delivered by iCargoxpress
                    Delivery Inc.,
                    or picked up from our warehouse, in good condition. The package has been inspected upon delivery and
                    found
                    free of visible damage. By signing below, I confirm that the delivery was completed satisfactorily.
                </p>
            </table>
            <table class="table-main">
                <tr>
                    <td>
                        <table class="table-inner two-col">
                            <tr>
                                <td class="td-head">STATUS OF THE BOX UPON DELIVERY</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="sixside" name="sixside" />
                                    <label for="sixside">SIX SIDE INSPECTED</label>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="good" name="good" />
                                    <label for="good">IN GOOD CONDITION</label>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table class="table-inner two-col">
                            <tr>
                                <td>

                                    <textarea id="story" name="story" rows="5" cols="75">
REMARKS
</textarea>
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


            <table class="table-main">
                <tr>
                    <td>
                        <table class="table-inner two-col">
                            <tr>
                                <td>DRIVER NAME<span class="line">{{ $driver->full_name ?? '' }}</span></td>
                                <td>ASSISTANT<span class="line">{{ $leadman->full_name ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>DELIVERY DATE<span class="line"></span></td>
                                <td>PLATE NO<span class="line">{{ $truck->plate_no ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>TIME<span class="line"></span></td>
                                <td>TRUCK<span class="line"></span></td>
                            </tr>
                            <tr>
                                <td colspan="2">SIGNATURE<span class="line"></span></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table class="table-inner two-col">
                            <tr>
                                <td colspan="2">RECIPIENT NAME<span class="line"></span></td>

                            </tr>
                            <tr>
                                <td colspan="2">RELATIONSHIP TO SENDER <span class="line"></span></td>
                            </tr>
                            <tr>
                                <td>ID TYPE<span class="line"></span></td>
                                <td>ID NUMBER <span class="line"></span></td>
                            </tr>
                            <tr>
                                <td colspan="2">SIGNATURE <span class="line"></span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        {{-- secton 2 --}}
        <br>
        <div class="cut-guide"></div>
        <br>
        <div class="half">
            <table class="table-main">

                <table class="table-inner three-col">
                    <td>
                        <img class="logo-left" src="{{ public_path('storage/'.$consolidator->logo) }}" alt="logo" /><br>
                        <span> {{$consolidator->website }}<br>
                            {{ $consolidator->email }}<br>
                           {{$consolidator->mobile_no}}</span>
                    </td>
                    <td>
                        <img class="logo-center" src="{{ public_path('storage/logo/icargologo.png') }}"
                            alt="logo" /><br>
                        <span style="font-size:18px;font-weight:bold;">DELIVERY RECEIPT</span>
                    </td>
                    <td>
                        WWW.ICARGOXPRESS.NET<br>
                        Unit D, Riverside, Tanzang Luma VI, Imus City, Cavite 4103 Philippines <br>
                        +639178509815<br>
                        INQUIRIES@ICARGOXPRESS.COM
                    </td>
                    </tr>
                </table>

            </table>
            <table class="table-main">
                <tr>
                    <!-- First main td: split into 2 -->
                    <td>
                        <table class="table-inner two-col">
                            <tr>
                                <td class="td-head">SENDER INFORMATION</td>
                            </tr>
                        
                                <td>NAME<span style="text-align:center; margin-left:5px;border-bottom: 1px solid #000;">{{ $invoice->sender_name ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>TRACKING NO<span class="line">{{ $invoice->invoice ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>ORIGIN<span style="text-align:center; margin-left:5px;border-bottom: 1px solid #000;">{{$consolidator->company_name ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>BATCH NO<span class="line">{{ $invoice->batchno ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>BOX TYPE<span class="line">{{ $invoice->boxtype ?? '' }}</span> </td>
                            </tr>
                        </table>
                    </td>

                    <!-- Second main td: split into 2 -->
                    <td>
                        <table class="table-inner two-col">
                            <tr>
                                <td class="td-head">RECEIVER INFORMATION</td>
                            </tr>
                            <tr>
                                <td>NAME<span style="text-align:center; margin-left:5px;border-bottom: 1px solid #000;">{{ $invoice->receiver_name ?? '' }}</span></td>
                            </tr>               
                            <tr>
                                 <td colspan="2">ADDRESS<span style="text-align:center; margin-left:5px;border-bottom: 1px solid #000;">{{ $invoice->receiver_address ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>PROVINCE <span class="line">{{ $invoice->receiver_province ?? '' }}</span></td>
                                <td>CITY:<span class="line">{{ $invoice->receiver_city ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>BARANGAY<span style="text-align:center; margin-left:5px;border-bottom: 1px solid #000;">{{ $invoice->receiver_barangay ?? '' }}</span></td>
                                <td>POSTALCODE<span class="line">{{ $invoice->receiver_postalcode ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>EMAIL<span class="line">{{ $invoice->receiver_email ?? '' }}</span></td>
                                <td>PHONE <span class="line">{{ $invoice->receiver_mobile_no ?? '' }}</span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="table-main">
                <br>
                <span>Acknowledgement Receipt</span>
                <p style="text-align:justify;">
                    This is to formally acknowledge that I have received the box/item(s) delivered by iCargoxpress
                    Delivery Inc.,
                    or picked up from our warehouse, in good condition. The package has been inspected upon delivery and
                    found
                    free of visible damage. By signing below, I confirm that the delivery was completed satisfactorily.
                </p>
            </table>
            <table class="table-main">
                <tr>
                    <td>
                        <table class="table-inner two-col">
                            <tr>
                                <td class="td-head">STATUS OF THE BOX UPON DELIVERY</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="sixside" name="sixside" />
                                    <label for="sixside">SIX SIDE INSPECTED</label>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="good" name="good" />
                                    <label for="good">IN GOOD CONDITION</label>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table class="table-inner two-col">
                            <tr>
                                <td>

                                    <textarea id="story" name="story" rows="5" cols="75">
REMARKS
</textarea>
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


            <table class="table-main">
                <tr>
                    <td>
                        <table class="table-inner two-col">
                            <tr>
                                <td>DRIVER NAME<span class="line">{{ $driver->full_name ?? '' }}</span></td>
                                <td>ASSISTANT<span class="line">{{ $leadman->full_name ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>DELIVERY DATE<span class="line"></span></td>
                                <td>PLATE NO<span class="line">{{ $truck->plate_no ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>TIME<span class="line"></span></td>
                                <td>TRUCK<span class="line"></span></td>
                            </tr>
                            <tr>
                                <td colspan="2">SIGNATURE<span class="line"></span></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table class="table-inner two-col">
                            <tr>
                                <td colspan="2">RECIPIENT NAME<span class="line"></span></td>

                            </tr>
                            <tr>
                                <td colspan="2">RELATIONSHIP TO SENDER <span class="line"></span></td>
                            </tr>
                            <tr>
                                <td>ID TYPE<span class="line"></span></td>
                                <td>ID NUMBER<span class="line"></span></td>
                            </tr>
                            <tr>
                                <td colspan="2">SIGNATURE<span class="line"></span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>