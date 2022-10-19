@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
    تعديل فاتورة
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تعديل فاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
    <!-- row -->
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('invoices.update', $invoice->id) }}" method="post"
                        autocomplete="off">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="inputName" name="invoice_number"
                                    title="يرجي ادخال رقم الفاتورة" required value="{{old('invoice_number') ?: $invoice->invoice_number}}">
                            </div>

                            <div class="col">
                                <label>تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{old('invoice_date') ?: $invoice->invoice_date}}" required>
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD"
                                    type="text" required value="{{old('due_date', $invoice->due_date)}}">
                            </div>

                        </div>

                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">القسم</label>
<!--when user make a click we take the value = section->id in $(this).val()) and send it to js code -->
<!-- when change in select box happen the js code start to execute -->
                                <select name="section_id" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="{{old('section_id', $invoice->section->id)}}" selected disabled>{{$invoice->section->section_name}}</option>
<!--for this i get all sections data from section.create controller -->
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{$section->section_name}}</option>
                                    @endforeach
                                </select>
                            </div>
<!--the option tag is not here cause it will execute in js code after ajax go to controlldes invoices and call functioon get product to get id, product_name by section_id  -->
                            <div class="col">
                                <label for="inputName" class="control-label">المنتج</label>
                                <select id="product" name="product" class="form-control">
                                    <option value="{{$invoice->product}}">{{$invoice->product}}</option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ التحصيل</label>
                                <input type="text" class="form-control" id="inputName" name="amount_collection" value="{{old('amount_collection',$invoice->amount_collection)}}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                        </div>
                        {{-- 3 --}}
                        <div class="row">
<!--take the value of commisson entered by user and send it in js code below this code start execute when user entred the value-->
                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ العمولة</label>
                                <input type="text" class="form-control form-control-lg" id="amount_commission"
                                    name="amount_commission" title="يرجي ادخال مبلغ العمولة " value="{{old('amount_commission',$invoice->amount_commission)}}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required>
                            </div>
<!--take the value of discount entered by user and send it in js code below this code start execute when user entred the value-->
                            <div class="col">
                                <label for="inputName" class="control-label">الخصم</label>
                                <input type="text" class="form-control form-control-lg" id="discount" name="discount"
                                    title="يرجي ادخال مبلغ الخصم " value="{{old('discount', $invoice->discount)}}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required>
                            </div>
<!--take the value of rate_vate choosed by user and send it in js code below this code start execute when user entred the value-->
                            <div class="col">
                                <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                <select name="rate_vat" id="rate_vat" class="form-control" onchange="myFunction()">
                                    <!--placeholder-->
                                    <option value="{{old('rate_vat', $invoice->rate_vat)}}" selected disabled>{{$invoice->rate_vat}}</option>
                                    <option value=" 5%">5%</option>
                                    <option value="10%">10%</option>
                                </select>
                            </div>
                        </div>
                        {{-- 4 --}}
<!-- this dont send to js but i make a link between them to used in calc -->
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="value_vat" name="value_vat" readonly value="{{old('value_vat', $invoice->value_vat)}}">
                            </div>
                            <div class="col">
                                <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="total" name="total" readonly value="{{old('total', $invoice->total)}}">
                            </div>
                        </div>
                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">ملاحظات</label>
                                <textarea class="form-control" id="exampleTextarea" name="note"  value="{{old('note', $invoice->note)}}" rows="3"></textarea>
                            </div>
                        </div><br>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>

<script>
    $(document).ready(function() {
        $('select[name="section_id"]').on('change', function() { /* فى تاج ال السلكت فوق لما اجى اختار حاجه يبدا الكود ده يتنفذ */
            var SectionId = $(this).val(); // هحط الفاليو اى دى اللى جبتها من فوق فى فار
            if (SectionId) { // هيحصل شيك لو الفاليو موجوده هينفذ كود الاجاكس
                $.ajax({
                    url: "{{ URL::to('section') }}/" + SectionId, // هيروح على روت السكشن وهياخد معاه ال اى دى عشان يجيب البرودكت اللى تبع ال اى دى ده
                    type: "GET", //بديله نوع الريكويست
                    dataType: "json", // الداتا اللى هنرجع من نوع
                    success: function(data) { // هنا لما يرجع با الداتا
                        $('select[name="product"]').empty();//هيروح ع تاج السلكت بتاع البرودكت اللى مفيهوش تاج الاوبشن هيتاكد انه فاضى او هيفضيه
                        $.each(data, function(key, value) {//هيعمل لووب ع الداتا اللى جابها هو اصلا هيرجع ب اىدى بتاع البرودكت والقيمه بتاعته
                            $('select[name="product"]').append('<option value="' + //هنا هيحط ال اى دى وهيعرض الفاليو
                                value + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>


    <script>
        function myFunction() {

            var amount_commission = parseFloat(document.getElementById("amount_commission").value);//فار لقيمه العموله
            var discount = parseFloat(document.getElementById("discount").value);//فار لقيمه الخصم
            var rate_vat = parseFloat(document.getElementById("rate_vat").value);//فار لنسبه الصريبه
            var value_vat = parseFloat(document.getElementById("value_vat").value);// فار لقيمه الضريبه

            var Amount_Commission2 = amount_commission - discount;      //amount of commission after discount


            if (typeof amount_commission === 'undefined' || !amount_commission) {

                alert('يرجي ادخال مبلغ العمولة ');      //check if amount of commission is noot entered

            } else {
                var intResults = Amount_Commission2 * rate_vat / 100;   //calc amount of rate vate

                var intResults2 = parseFloat(intResults + Amount_Commission2);  //calc the total amount

                sumq = parseFloat(intResults).toFixed(2);       // change the shpae of the number

                sumt = parseFloat(intResults2).toFixed(2);

                document.getElementById("value_vat").value = sumq;  //pass the value to value_vat id

                document.getElementById("total").value = sumt;      // pass the value to total id

            }

        }

    </script>


@endsection

