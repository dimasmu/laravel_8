@extends('layouts.dashboard',['title' => 'List System','active' => 2])
@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .table-res {
            width: 100%
        }
    </style>
</head>
<link href="{{asset('css/datatables.min.css')}}" rel="stylesheet">
<div class="container-fluid p-0" id="container">
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card flex-fill w-100">
                <div class="card-header" style="background-color: white;">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4" role="group" aria-label="Add">
                        <a onclick="routeAdd()" class="btn btn-success"><i class="fa-light fa-plus"></i> | Add Data</a>
                    </div>
                    <div class="row">
                        <table class="table diplay nowrap" style="width: 100%;overflow: auto;" id="system">
                            <thead>
                                <tr>
                                    <th scope="col" class="width-th">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col">Updated By</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Updated at</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                {{-- @foreach($data as $index => $row)
                                <tr>
                                    <th scope="row">{{$index+1}}</th>
                                    <td>{{$row->name}}</td>
                                    @if ($row->is_status === 1)
                                    <td>Aktif</td>
                                    @else
                                    <td>Tidak aktif</td>
                                    @endif
                                    <td>{{$row->created_by}}</td>
                                    <td>{{$row->updated_by}}</td>
                                    <td>{{$row->created_at}}</td>
                                    <td>{{$row->updated_at}}</td>
                                    <td>
                                        <button onClick="routeEdit({{$row->id}})" type="button"
                                            class="btn btn-primary"><i
                                                class="fa-solid fa-pen-to-square me-2"></i>Edit</button>
                                        <button onClick="routeDelete({{$row->id}})" type="button"
                                            class="btn btn-danger"><i class="fa-solid fa-trash me-2"></i>Delete</button>
                                        <button onClick="routeDetail({{$row->id}})" type="button"
                                            class="btn btn-info"><i
                                                class="fa-solid fa-file-zipper me-2"></i>Detail</button>
                                    </td>
                                </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                        {{-- @include('layouts.loading') --}}
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="add_modal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModal">Add Standard Field</h5>
                                </div>
                                <form class="modal-body" id="inner_modal">
                                    @csrf
                                    <div class="mb-3 col-md-12 col-xs-12 col-sm-12">
                                        <label for="stdId" class="form-label">Standard Field Id</label>
                                        <input type="text" name="stdId" class="form-control disable" id="std_field_id"
                                            value="{{isset($id)}}" readonly>
                                    </div>
                                    <div class="mb-3 col-md-12 col-xs-12 col-sm-12">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{isset($name)}}">
                                    </div>
                                    <div class="mb-3 col-md-12 col-xs-12 col-sm-12 form-check form-switch">
                                        <label for="status" class="form-label">Status</label>
                                        <input class="form-check-input" type="checkbox" role="switch" id="status"
                                            value="{{isset($status)}}">
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" id="dissmis-btn"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="submit_button" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('javascript')
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('js/sweetalert.min.js')}}"></script>
<script type="text/javascript">
    // let i = [
//         @foreach ($data as $index => $row)
//             ["{{$row->name}}"],
//          @endforeach
//     ]
//     console.log(i)
    function routeAdd(){
        $('#add_modal').modal('show');
        $('#name').val('');
        $('#std_field_id').val('');
        $('#status').prop('checked', false);
    }

    $('#dissmis-btn').click(function() {
        $('#add_modal').modal('hide');
    })
    let table = null;
    $(document).ready(function () {
        table = $('#system').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollCollapse: true,
            ajax: "{{route('api.standard_field.all')}}",
            columnDefs: [
                {
                    "data" : 'no',
                    "target" : [0]
                },
                {
                    "data" : 'name',
                    "target" : [1]
                },
                {
                    "render": function ( data, type, full, meta ) {
                        let createHtml = '';
                        var divArea = document.createElement('textarea');
                        divArea.innerHTML = full.status;
                        createHtml+=divArea.value;
                        return createHtml;
                    },
                    "data" : null,
                    "target" : [2]
                },
                {
                    "data" : 'created_by',
                    "target" : [3]
                },
                {
                    "data" : 'updated_by',
                    "target" : [4]
                },
                {
                    "data" : 'created_at',
                    "target" : [5]
                },
                {
                    "data" : 'updated_at',
                    "target" : [6]
                },
                {
                    "data" : 'action',
                    "target" : [7]
                }
            ],
        });
        // $('#loading').hide();
        // $('#system tbody').removeClass('d-none');

        $("#submit_button").click(function() {
            swal({
                title: "Are you sure to save?",
                showCancelButton: true,
                icon: "warning",
                buttons: true,
                dangerMode: true
            })
            .then((next) => {
                if (next) {
                    let dataSerialize = $('#inner_modal').serializeArray();
                    let status = $('#status').is(':checked');
                    dataSerialize.push({name: "status", value: status})
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: dataSerialize, //function yang dipakai agar value pada form-control seperti input, textarea, select dll dapat digunakan pada URL query string ketika melakukan ajax request
                        url: "/system/standard-field", //url simpan data
                        type: "POST", //karena simpan kita pakai method POST
                        dataType: 'json', //data tipe kita kirim berupa JSON
                        success: function (data) { //jika berhasil
                            swal({
                                title: data.title,
                                text: data.text,
                                icon: "success",
                                buttons: false,
                                timer: 800
                            }).then(function(){
                                table.ajax.reload();
                                $('#add_modal').modal('hide');
                            })
                        },
                        error: function (data) { //jika error tampilkan error pada console
                            console.log(data)
                            swal({
                                title: "Error Insert!",
                                text: data.responseJSON.text,
                                icon: "error"
                            });
                            console.log('Error:', data);
                        }
                    });
                } else {

                }
            })
        })
    })

    function routeEdit(id){
        let urlReplace = "{{ route('api.standard_field_edit',[':id'])}}".replace(':id', id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: id,
            url: urlReplace,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                let status = data.is_status === 1 ? true : false;
                $("#add_modal").modal("show");
                $('#name').val(data.name);
                $('#std_field_id').val(data.id);
                $('#status').prop('checked', status);
            },
            error: function (data) {
                swal({
                    title: "Error Insert!",
                    text: data.responseJSON.message,
                    icon: "error"
                });
                console.log('Error:', data);
            }
        });
    }

    function routeDelete(id){
        swal({
            title: 'Are you sure to delete?',
            showCancelButton: true,
            icon: "warning",
            buttons: true,
            dangerMode: true
        })
        .then((next) => {
            if (next) {
                $.ajax({
                    url: "/system/standard-field/"+id,
                    type: "DELETE",
                    data : {
                        _token : $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function (data) {
                        swal({
                            title: data.title,
                            text: data.text,
                            icon: "success",
                            buttons: false,
                            timer: 800
                        }).then( function () {
                            table.ajax.reload();
                        })
                    },
                    error: function (data) {
                        swal({
                            title: "Error Delete!",
                            text: data.responseJSON.message,
                            icon: "error"
                        });
                        console.log('Error:', data);
                    }
                });
            } else {

            }
        })
    }
</script>
@endsection
@endsection
