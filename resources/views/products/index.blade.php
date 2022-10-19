@extends('layouts.master')
@section('title', 'Products')
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
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
<!--flashing add session -->
                @if (session()->has('add'))
                <div class="alert alert-success alert-dismissable fade show" role="alert">
                    <strong>{{session()->get('add')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

<!--flashing update session -->
                @if (session()->has('update'))
                <div class="alert alert-success alert-dismissable fade show" role="alert">
                    <strong>{{session()->get('update')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

<!--flashing delete session -->
                @if (session()->has('delete'))
                <div class="alert alert-success alert-dismissable fade show" role="alert">
                    <strong>{{session()->get('delete')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

<!--print validate error -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error )
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
    <div class="row row-sm">
		<div class="col-xl-12">
		    <div class="card">
				<div class="card-header pb-0">
					<div class="d-flex justify-content-between">
					    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modalAdd"> اضافه منتج</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table text-md-nowrap" id="example1" data-page-length='10'>
							<thead>
								<tr>
									<th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">اسم المنتج</th>
									<th class="wd-15p border-bottom-0">اسم القسم</th>
									<th class="wd-20p border-bottom-0">الوصف</th>
									<th class="wd-15p border-bottom-0">العمليات</th>
								</tr>
									</thead>
									<tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($products as $product )
                                <tr>
									<td>{{++$i}}</td>
									<td>{{$product->product_name}}</td>
									<td>{{$product->section->section_name}}</td>
									<td>{{$product->text}}</td>
                                    <td>
                                        <!--edit button-->
                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                        data-id="{{ $product->id }}"
                                        data-product_name="{{$product->product_name}}"
                                        data-section_name="{{$product->section->section_name}}"
                                        data-text="{{ $product->text }}" data-toggle="modal"
                                        href="#modalEdit" title="تعديل"><i class="las la-pen"></i></a>
                                        <!--delete button-->
                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id="{{$product->id}}" data-product_name="{{$product->product_name}}"
                                        data-section_name="{{$product->section->section_name}}" data-text="{{$product->text}}" data-toggle="modal" href="#modalDelete" title="مسح"><i class="las la-trash"></i></a>
                                    </td>
								</tr>
                                @endforeach
							</tbody>
						</table>
					</div>
				</div>
            </div>
					<!--/div-->
	</div>
        </div>
				<!-- /row -->
<!--add product modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title">اضافه منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><spanaria-hidden="true">&times;</span></button>
        </div>
    <div class="modal-body">
        <form action="{{route('products.store')}}" method="POST" autocomplete="off">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail">اسم المنتج</label>
                <input type="text" name="product_name" class="form-control" id="product_name">
            </div>

            <div class="form-group">
                <label>اسم القسم</label>
                <select name="section_id" id="section_id" required class="form-control">
                    <option selected value="" disabled>حدد القسم</option>
                    @foreach ($sections as $section )
                        <option value="{{$section->id}}">{{$section->section_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">الوصف</label>
                <textarea  name="text" id="text" rows="3" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">تاكيد</button>
                <button type="button" class="btn btn-secondry" data-dismiss="modal">اغلاق</button>
            </div>
        </form>
    </div>
    </div>
    </div>
</div>
<!-- end of add product modal -->
<!-- Edit product modal-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">تعديل المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><spanaria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="products/update" method="POST" autocomplete="off">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <input type="hidden" name="id" id="id">
                        <label for="exampleInputEmail">اسم المنتج</label>
                        <input type="text" name="product_name" class="form-control" id="product_name">
                    </div>

                    <div class="form-group">
                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                        <select name="section_name" id="section_name" required class="custom-select my-1 mr-sm-2">
                            @foreach ($sections as $section )
                                <option>{{$section->section_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">الوصف</label>
                        <textarea  name="text" id="text" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">تاكيد</button>
                        <button type="button" class="btn btn-secondry" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end of Edit product modal-->
<!-- delete product modal-->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">مسح المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><spanaria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="products/destroy" method="POST" autocomplete="off">
                    @csrf
                    @method('delete')
                    <div class="form-group">
                        <p>هل انت متاكد من مسح هذا</p>
                        <input type="hidden" name="id" id="id">
                        <label for="exampleInputEmail">اسم المنتج</label>
                        <input type="text" name="product_name" class="form-control" id="product_name" value="product_name">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">تاكيد</button>
                        <button type="button" class="btn btn-secondry" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end of delete modal -->
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
    $('#modalEdit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        console.log(id)
        var product_name = button.data('product_name')
        console.log(product_name)
        var section_name = button.data('section_name')
        console.log(section_name)
        var text = button.data('text')
        console.log(text)
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #product_name').val(product_name);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #text').val(text);
    })
</script>
<script>
    $('#modalDelete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        console.log(id)
        var product_name = button.data('product_name')
        console.log(product_name)
        var section_name = button.data('section_name')
        console.log(section_name)
        var text = button.data('text')
        console.log(text)
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #product_name').val(product_name);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #text').val(text);
    })
</script>
@endsection

