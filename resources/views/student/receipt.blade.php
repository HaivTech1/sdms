<div id="invoice-POS">
    <div class="hero">
        <img src="{{ asset('storage/' .application('image')) }}" alt="{{ application('name') }}" width="100px">
    </div>
    <div>
        {{-- prit section --}}
        <div class="print_content">
            <div style="display: flex; justify-content: center">
                <img src="{{ asset('storage/' .application('image')) }}" alt="{{ application('name') }}" width="100px">
            </div>
            <center id="top">
                <div class="info">
                    <h2 style="font-size: 20px; font-weight: bold; text-decoration: uppercase; background-color: rgba(37, 41, 88, 0.7); border-radius: 10px; padding: 10px; color: #ffffff">{{ application('name')}}</h2>
                    <address style="font-size: 8px">{{ application('address')}}</address>
                </div>
            </center>

            <div class="mid">
                <div class="info">
                    <address style="font-size: 8px">
                        {{ application('description')}} <br>
                        {{ application('email')}} <br>
                        {{ application('line1') }}, {{ application('line2') }}
                    </address>
                </div>
            </div>
        </div>
        <!-- end of receipt mid -->
        
        <div class="customer">
            <div class="table-wrapper">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <th style="text-align: left">Paid By:</th>
                            <td>{{ $payment->paidBy() }}</td>
                        </tr>
                        <tr>
                            <th style="text-align: left">Ref. No:</th>
                            <td>{{ $payment->referenceId() }}</td>
                        </tr>
                        <tr>
                            <th style="text-align: left">Trasac. Id:</th>
                            <td>{{ $payment->transactionId() }}</td>
                        </tr>
                        <tr>
                            <th style="text-align: left">Term/Session:</th>
                            <td>{{ $payment->term->title() }}-{{ $payment->period->title() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="" style="width: 20%">
                            <h2>Name</h2>
                        </td>
                        <td class="Hours">
                            <h2>Class</h2>
                        </td>
                        <td class="Rate">
                            <h2>Payable</h2>
                        </td>
                        <td class="Rate">
                            <h2>Paid</h2>
                        </td>
                    </tr>
                    @php
                        $student = \App\Models\Student::findOrFail($payment->student_uuid);
                    @endphp
                    
                    <tr class="service">
                        <td class="tableitem">
                            <h5 class="itemtext">{{ $student->fullName() }}</h5>
                        </td>
                        <td class="tableitem">
                            <h5 class="itemtext">{{ $student->grade->title() }}</h5>
                        </td>
                        <td class="tableitem">
                            <h5 class="itemtext">{{ trans('global.naira') }}{{ number_format($payment->payable(), 2) }}</h5>
                        </td>
                        <td class="tableitem">
                            <h5 class="itemtext">{{ trans('global.naira') }}{{ number_format($payment->amount(), 2) }}</h5>
                        </td>
                    </tr>
                    <tr class="tabletitle">
                        <td></td>
                        <td class="itemtext" colspan="2">To Balance</td>
                        <td class="itemtext">  {{ trans('global.naira') }}{{ number_format($payment->balance(), 2) }} </h2>
                        </td>
                    </tr>
                </table>

                @if ($payment->balance() > 0)
                    <div id="legalcopy">
                        <address class="legal" style="font-size: 8px">
                        ** Please endeviour to pay your balance early. **
                            <br>
                            <span>** Thanks you! **</span>
                        </address>
                    </div>
                @endif

                <div class="serial-number" style="font-size:10px; ">
                    <span>{{ Date('d:m:Y h:i:s') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="d-print-none">
            <div class="float-end">
                <a href="javascript:window.print()"
                    class="btn btn-success waves-effect waves-light me-1"><i
                        class="fa fa-print"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div style="display: flex; justify-content: center; align-items: baseline" class="hidden-print">
    <div style="margin-top: 10px; font-size: 10px">
        <div class="downloadcontainer downloadfile" style="display: flex; justify-content: center">
            <div style="margin-left: 5px">
                <button id="downloadbutton" class="button">Print Reciept</button>
            </div>
        </div>
        {{-- <button type="button">download Receipt</button> --}}
    </div>

    <a style='text-decoration: none; color: #000000; margin-left: 5px' href="{{ route('dashboard') }}">Go back home</a>
</div>

<style>
    .hero {
        position: absolute;
        opacity: 0.1;
        background-repeat: no-repeat;
    }

    #invoice-POS {
        position: relative;
        padding: 1em;
        margin: 0 auto;
        width: 15em;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.5em;
        font-family: monospace;
        line-height: 10px;
        border: 1px dashed #000000
    }

    #invoice-POS ::selection {
        background: #f315f3;
        color: #fff;
    }

    #invoice-POS ::-moz-selection {
        background: rgb(2, 15, 133);
        color: #fff;
    }

    #invoice-POS h1 {
        font-size: 1.5em;
        color: #222;
    }

    #invoice-POS h2 {
        font-size: 0.9em;
    }

    #invoice-POS h3 {
        font-size: 1.2em;
        font-weight: 300;
        line-height: 2em;
    }

    #invoice-POS p {
        font-size: 0.7em;
        line-height: 1.2em;
        color: #666;
    }

    #invoice-POS .top,
    #invoice-POS .mid,
    #invoice-POS .bot {
        border-bottom: 1px solid #eee;
    }

    #invoice-POS .top {
        min-height: 100px;
    }

    #invoice-POS .mid {
        min-height: 50px;
    }

    #invoice-POS .bot {
        min-height: 50px;
        font-size: 0.8em;
    }

    #invoice-POS #top .logo img {
        height: 10px;
        width: 60px;
        background-image: url('/images/logo.png') no-repeat;
        background-size: 60px 60px;
    }

    #invoice-POS .info {
        display: block;
        margin-left: 0;
        text-align: center;
    }

    #invoice-POS .title {
        float: right;
    }

    #invoice-POS .title p {
        text-align: right;
    }

    #invoice-POS table {
        width: 100%;
        border-collapse: #eee;
    }

    #invoice-POS .tabletitle {
        font-size: 1.0em;
        background: #eee;
    }

    #invoice-POS .service {
        border-bottom: 1px solid #eee;
    }

    #invoice-POS .service {
        border-bottom: 1px solid #eee;
    }

    #invoice-POS .item {
        width: 24mm;
    }

    #invoice-POS .itemtext {
        font-size: 10px;
        font-weight: 500;
        text-align: center
    }

    #invoice-POS #legalcopy {
        margin-top: 5mm;
        text-align: center;
    }

    .serial-number {
        margin-top: 5px;
        margin-bottom: 2mm;
        text-align: center;
        font-size: 12px;
    }

    .serial {
        margin-top: 5mm;
        margin-bottom: 2mm;
        text-align: center;
        font-size: 10px !important;
    }

    .customer{
        display: flex;
        justify-content: space-between;
        margin: 2px 0;
        padding: 2px 0px;
        border-top: 1px dashed black;
        border-bottom: 1px dashed black
    }

    @media print {
        .hidden-print,
        .hidden-print * {
            display: none !important;
        }
    }
</style>

<script>
    var downloadButton = document.getElementById("downloadbutton");

    downloadButton.addEventListener("click", function () {
        downloadButton.type = 'hidden'; 
        window.print();
    });

</script>