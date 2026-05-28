<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .header {
            background-color: #1e3a5f;
            padding: 24px 32px;
            color: #ffffff;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
        .body {
            padding: 32px;
            color: #333333;
            font-size: 15px;
            line-height: 1.8;
        }
        .attachment-section {
            padding: 0 32px 32px;
        }
        .attachment-section h3 {
            color: #1e3a5f;
            font-size: 14px;
            margin-bottom: 12px;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 8px;
        }
        .attachment-image {
            width: 100%;
            max-width: 500px;
            height: auto;
            border-radius: 6px;
            border: 1px solid #dddddd;
            margin-bottom: 12px;
            display: block;
        }
        .attachment-file {
            display: inline-block;
            padding: 8px 16px;
            background-color: #f0f4ff;
            border: 1px solid #c0d0ff;
            border-radius: 4px;
            color: #1e3a5f;
            font-size: 13px;
            margin-bottom: 8px;
        }
        .footer {
            background-color: #f0f0f0;
            padding: 16px 32px;
            text-align: center;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="wrapper">

        {{-- Header --}}
        <div class="header">
            Invoice Issue Notification
        </div>

        {{-- Body --}}
        {{-- Body --}}
        <div class="body">
            @isset($record)
               <table style="width:100%; border-collapse:collapse; font-size:15px;">
            <tr>
                <td style="padding:8px 0; border-bottom:1px solid #f0f0f0;">
                    <span style="display:block; font-weight:bold; color:#1e3a5f; font-size:15px; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Invoice</span>
                    <span style="display:block; color:#333333;">{!! nl2br(e($record->invoice)) !!}</span>
                </td>
            </tr>
            <tr>
                <td style="padding:8px 0; border-bottom:1px solid #f0f0f0;">
                    <span style="display:block; font-weight:bold; color:#1e3a5f; font-size:15px; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Box Issue</span>
                    <span style="display:block; color:#333333;">{!! nl2br(e($record->boxissue->issue_type)) !!}</span>
                </td>
            </tr>
            <tr>
                <td style="padding:8px 0; border-bottom:1px solid #f0f0f0;">
                    <span style="display:block; font-weight:bold; color:#1e3a5f; font-size:15px; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Remarks</span>
                    <span style="display:block; color:#333333; line-height:1.8;">{!! nl2br(e($record->remarks ?? 'N/A')) !!}</span>
                </td>
            </tr>
        </table>
            @endisset
        </div>

        {{-- Attachments --}}

        {{-- Footer --}}
        {{-- <div class="footer">
            This is an automated notification. Please do not reply.
        </div> --}}

    </div>
</body>
</html>
