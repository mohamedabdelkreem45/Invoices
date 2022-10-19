
@extends('layouts.master')
@section('title', 'تفاصيل الفاتوره')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<!---Internal  Prism css-->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
<!---Internal Input tags css-->
<link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
<!--- Custom-scroll -->
<link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتوره</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
@if (session()->has('add'))
    <div class="alert alert-success alert-dismissable fade show" role="alert">
        <strong>{{session()->get('add')}}</strong>
    </div>
@endif
@if (session()->has('delete'))
    <div class="alert alert-danger alert-dismissable fade show" role="alert">
        <strong>{{session()->get('delete')}}</strong>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error )
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
				<!-- row opened -->
<div class="row row-sm">
	<div class="col-xl-12">
						<!-- div -->
		<div class="card mg-b-20" id="tabs-style2">
			<div class="card-body">
				<div class="text-wrap">
					<div class="example">
						<div class="panel panel-primary tabs-style-2">
							<div class=" tab-menu-heading">
								<div class="tabs-menu1">
					<!-- Tabs -->
									<ul class="nav panel-tabs main-nav-line">
										<li><a href="#tab4" class="nav-link active" data-toggle="tab">تفاصيل الفاتوره</a></li>
										<li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
										<li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
									</ul>
								</div>
							</div>
							<div class="panel-body tabs-menu-body main-content-body-right border">
								<div class="tab-content">
									<div class="tab-pane active" id="tab4">
                                        <div class="table-responsive mt-15">
                                            <table class="table table-striped" style="text-align:center">
                                                <tbody>
                                                    <td>{{$invoice->invoice_number}}</td>
                                                    <tr>
                                                        <th scope="row">رقم الفاتوره</th>
                                                        <th scope="row">تاريخ الاصدار</th>
                                                        <td>{{$invoice->invoice_Date}}</td>
                                                        <th scope="row">تارخ الاستحقاق</th>
                                                        <td>{{$invoice->due_date}}</td>
                                                        <th scope="row">القسم</th>
                                                        <td>{{$invoice->section->section_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">المنتج</th>
                                                        <td>{{$invoice->product}}</td>
                                                        <th scope="row">مبلغ التحصيل</th>
                                                        <td>{{$invoice->amount_collection}}</td>
                                                        <th scope="row">مبلغ العموله</th>
                                                        <td>{{$invoice->amount_commission}}</td>
                                                        <th scope="row">الخصم</th>
                                                        <td>{{$invoice->discount}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">نسبه الضريبه</th>
                                                        <td>{{$invoice->rate_vat}}</td>
                                                        <th scope="row">قيمه الضريبه</th>
                                                        <td>{{$invoice->value_vat}}</td>
                                                        <th scope="row">الجمالى مع الضريبه</th>
                                                        <td>{{$invoice->total}}</td>
                                                        <th scope="row">الحاله االحاليه</th>
                                                        @if ($invoice->Value_Status == 0)
                                                            <td><span class="badge badge-pill badge-danger">{{$invoice->Status}}</span></td>
                                                        @elseif ($invoice->Value_Status == 1)
                                                            <td ><span class="badge badge-pill badge-danger">{{$invoice->Status}}</span></td>
                                                        @else
                                                            <td>{{$invoice->Status}}</td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">ملاحظات</th>
                                                        <td>{{$invoice->note}}</td>
                                                    </tr>
                                                 </tbody>
                                            </table>
                                        </div>
									</div>
									<div class="tab-pane" id="tab5">
                                        <div class="table-responsive mt-15">
                                            <table class="table center-aligned-table mb-0 table-hover" style="text-align-center">
                                                <thead>
                                                    <tr class="text-dark">
                                                        <th>#</th>
                                                        <th>رقم الفاتوره </th>
                                                        <th>نوع المنتج</th>
                                                        <th>القسم</th>
                                                        <th>حاله الدفع</th>
                                                        <th>تاريخ الدفع</th>
                                                        <th>تاريخ الاضافه</th>
                                                        <th>ملاحظات</th>
                                                        <th>المستخدم</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 0
                                                    @endphp
                                                    @foreach ($details as $detail )
                                                    <tr>
                                                        <td>{{++$i}}</td>
                                                        <td>{{$detail->invoice_number}}</td>
                                                        <td>{{$detail->product}}</td>
                                                        <td>{{$invoice->section->section_name}}</td>
                                                        @if ($detail->value_status == 0)
                                                        <td><span class="badge badge-pill badge-danger">{{$detail->status}}</span></td>
                                                        @elseif ($detail->value_status==1)
                                                        <td><span class="badge badge-pill badge-success">{{$detail->status}}</span></td>
                                                        @else
                                                        <td><span class="badge badge-pill badge-warning">{{$detail->status}}</span></td>
                                                        @endif
                                                        <td>{{$detail->payment_date}}</td>
                                                        <td>{{$detail->created_at}}</td>
                                                        <td>{{$detail->note}}</td>
                                                        <td>{{$detail->user}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
									</div>

									<div class="tab-pane" id="tab6">
                                        <div class="card card-satatistics">
                                            <div class="card-body">
                                                <p class="text-danger"> صيغه المرفق pdf, jpeg, .jpg, png</p>
                                                <h5 class="card-title">اضافه المرفقات</h5>
                                                <form action="{{route('invoices_attachements.store')}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div>
                                                        <input name="pic" id="file_name"  type="file" required>
                                                        <input type="hidden" name="invoice_number" id="invoice_number" value="{{$invoice->invoice_number}}">
                                                        <input type="hidden" name="invoice_id" id="invoice_id" value="{{$invoice->id}}">
                                                        <label class="custom-file-input" for="file_name">حدد المرفق</label>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">تاكيد</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="table-responsive mt-15">
                                            <table class="table center-aligned-table mb-0 table-hover" style="text-align-center">
                                                <thead>
                                                    <tr class="text-dark">
                                                        <th>#</th>
                                                        <th>اسم الملف</th>
                                                        <th>قام بالاضافه</th>
                                                        <th>تاريخ الاضافه</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 0;
                                                    @endphp
                                                    @foreach ($attachments as $attachment )
                                                    <tr>
                                                        <td>{{++$i}}</td>
                                                        <td>{{$attachment->file_name}}</td>
                                                        <td>{{$detail->user}}</td>
                                                        <td>{{$detail->created_at}}</td>
                                                        <td>
<a class="btn btn-success btn-sm" href="#" role="button" target="_blank"><i class="fas fa-eye"></i></a>
<a class="btn btn-primary btn-sm" href="#" download><i class="fas fa-download"></i></a>
<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-toggle="modal" data-file_id="{{$attachment->id}}" data-file_name="{{$attachment->file_name}}" data-invoice_number="{{$invoice->invoice_number}}" href="#modalDelete" title="مسح"><i class="las la-trash"></i></a>
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
				</div>
			</div>
		</div>
	</div>
<!-- /div -->
</div>
<!--delete modal-->
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action = "{{route('invoices_attachements.remove_attachments')}}" method = "post" >
                        @csrf
                        @method('DELETE')
                        <div class="form-group">
                            <p>هل انت متاكد من من مسح هذا المرفق</p>
                            <input type="hidden" name="file_id" id="file_id" value="">
                            <input type="hidden" name="file_name" id="file_name" value="">
                            <input type="hidden" name="invoice_number" id="invoice_number" value="">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--end DELETE modal-->
<!-- /row -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Jquery.mCustomScrollbar js-->
<script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Internal Input tags js-->
<script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
<!--- Tabs JS-->
<script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
<script src="{{URL::asset('assets/js/tabs.js')}}"></script>
<!--Internal  Clipboard js-->
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
<!-- Internal Prism js-->
<script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>
<script>
    $('#modalDelete').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)
        var file_id = button.data('file_id')
        var file_name = button.data('file_name')
        var invoice_number = button.data('invoice_number')
        var modal = $(this)

        modal.find('.modal-body #file_id').val(file_id);
        modal.find('.modal-body #file_name').val(file_name);
        modal.find('.modal-body #invoice_number').val(invoice_number);
    })
</script>
@endsection
