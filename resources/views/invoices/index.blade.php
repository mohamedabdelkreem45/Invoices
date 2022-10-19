@extends('layouts.master')
@section('title', 'invoices')
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفوتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه</span>
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
@if (session()->has('edit'))
<div class="alert alert-success alert-dismissable fade show" role="alert">
    <strong>{{session()->get('edit')}}</strong>
</div>
@endif
@if (session()->has('delete'))
<div class="alert alert-success alert-dismissable fade show" role="alert">
    <strong>{{session()->get('delete')}}</strong>
</div>
@endif
<!-- row opened -->
<div class="row row-sm">
	<div class="col-xl-12">
		<div class="card">
			<div class="card-header pb-0">
                <span>
                    <a href="{{ route('invoices.create') }}" class="btn btn-success">
                        <i class="fa fa-plus"></i>
                        اضافه فاتوره
                    </a>
                </span>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table  id="example1">
						<thead>
							<tr>
								<th>#</th>
								<th>رقم الفاتورة</th>
								<th>تاريخ القاتورة</th>
								<th>تاريخ الاستحقاق</th>
								<th>المنتج</th>
								<th>القسم</th>
								<th>الخصم</th>
								<th>نسبة الضريبة</th>
								<th>قيمة الضريبة</th>
								<th>الاجمالي</th>
								<th>الحالة</th>
								<th>ملاحظات</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
                            @php
                                $i=0
                            @endphp
                            @foreach ($invoices as $invoice )
							<tr>
								<td>{{++$i}}</td>
								<td>{{$invoice->invoice_number}}</td>
								<td>{{$invoice->invoice_date}}</td>
								<td>{{$invoice->due_date}}</td>
								<td>{{$invoice->product}}</td>
								<td><a href="{{route('invoices_details.edit', $invoice->id)}}">{{$invoice->section->section_name}}</a></td>
								<td>{{$invoice->discount}}</td>
								<td>{{$invoice->rate_vat}}</td>
								<td>{{$invoice->value_vat}}</td>
								<td>{{$invoice->total}}</td>
                                @if ($invoice->value_status == 0)
                                <td class="text-danger">{{$invoice->status}}</td>
                                @else
                                <td class="text-success">{{$invoice->status}}</td>
                                @endif
								<td>{{$invoice->note}}</td>
								<td>
                                    <!--edit button-->
                                    <a class="btn btn-sm btn-info"
                                    href="{{route('invoices.edit', $invoice->id)}}" title="تعديل"><i class="las la-pen"></i></a>
                                </td>
                                <td>
                                    <!--delete button-->
                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-toggle="modal" data-invoice_id="{{$invoice->id}}" href="#modalDelete" title="مسح"><i class="las la-trash"></i></a>
                                </td>
							</tr>
                            @endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!--/div-->
</div>
<!-- /row -->
<!--delete modal-->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حذف الفاتوره</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action = "invoices/destroy" method = "post" >
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                        <p>هل انت متاكد من حذف هذه الفاتوره</p>
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
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
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script>
    $('#modalDelete').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)
        var invoice_id = button.data('invoice_id')
        var modal = $(this)

        modal.find('.modal-body #invoice_id').val(invoice_id);
    })
</script>
@endsection
