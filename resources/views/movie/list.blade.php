@extends('layouts.dashboard',['title' => 'List Movies'])
@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .table-res{
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
                        <table class="table diplay nowrap @if(count($data) > 0) table-responsive @endif" style=" overflow:auto;" id="movie">
                            <thead>
                                <tr>
                                    <th scope="col" class="width-th">No</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Release</th>
                                    <th scope="col">Aired form</th>
                                    <th scope="col">Aired to</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Updated at</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider d-none">
                                @foreach($data as $index => $row)
                                <tr>
                                    <th scope="row">{{$index+1}}</th>
                                    <td>{{$row->title}}</td>
                                    <td>
                                        @if ($row->category !== null)
                                        @foreach ($row->category as $index)
                                            <span class="badge bg-primary">{{$index}}</span>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td>{{$row->release}}</td>
                                    <td>{{$row->aired_from}}</td>
                                    <td>{{$row->aired_to}}</td>
                                    <td>{{$row->duration}}</td>
                                    <td>{{$row->status}}</td>
                                    <td>{{$row->created_at}}</td>
                                    <td>{{$row->updated_at}}</td>
                                    <td>
                                        <button onClick="routeEdit({{$row->id}})" type="button"
                                            class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-2"></i>Edit</button>
                                        <button onClick="routeDelete({{$row->id}})" type="button" class="btn btn-danger"><i class="fa-solid fa-trash me-2"></i>Delete</button>
                                        <button onClick="routeDetail({{$row->id}})" type="button"
                                            class="btn btn-info"><i class="fa-solid fa-file-zipper me-2"></i>Detail</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @include('layouts.loading')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('javascript')
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap5.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#movie').DataTable();

        $('#loading').hide();
        $('#movie tbody').removeClass('d-none');
    });
    // var editButton = (id) => {
    //     window.location.href = "/update-movie/"+id;
    // }

    function routeAdd(){
        event.preventDefault();
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "get",
            url: "/open-movie",
            data: {
                CSRF_TOKEN
            },
            success: function (response) {
                $(".content").html(response);
                window.history.replaceState(null, null, "/open-movie");
            }
        });
        // location.href = '{{ url('/open-movie') }}';
    }

    function routeList(){
        window.location.href = "{{ url('/movie') }}";
    }

    function routeEdit(id){
        event.preventDefault();
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "get",
            url: "/update-movie/"+id,
            data: {
                CSRF_TOKEN
            },
            success: function (response) {
                $(".content").html(response);
                // window.history.replaceState(null, null, "/update-movie/"+id);
            }
        });
        // location.href = '{{ url('/open-movie') }}';
    }

    function routeDetail(id){
        event.preventDefault();
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "get",
            url: "/detail-movie/"+id,
            data: {
                CSRF_TOKEN
            },
            success: function (response) {
                $(".content").html(response);
                // window.history.replaceState(null, null, "/detail-movie/"+id);
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
                let urlReplace = "{{ route('delete_movie',[':id'])}}".replace(':id', id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: urlReplace,
                    type: "get",
                    dataType: 'json',
                    success: function (data) {
                        swal({
                            title: data.title,
                            text: data.text,
                            icon: "success",
                            buttons: false,
                            timer: 800
                        }).then( function () {
                            routeList();
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
