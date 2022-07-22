<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .width-th {
            width: 5%;
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#add_modal"><i class="fa-solid fa-plus me-2"></i>
                            Add data
                        </button>
                        <a class="btn btn-warning" onclick="location.href = '{{ url('/movie') }}';"><i
                                class="fa-solid fa-backward-step me-2"></i>Back</a>
                    </div>
                    <div class="row">
                        <table class="table diplay nowrap" style="width: 100%;overflow: auto;" id="detail_movie">
                            <thead>
                                <tr>
                                    <th scope="col" class="width-th">No</th>
                                    <th scope="col">episode</th>
                                    <th scope="col">link</th>
                                    <th scope="col">view</th>
                                    <th scope="col">like</th>
                                    <th scope="col">dislike</th>
                                    <th scope="col">created at</th>
                                    <th scope="col">updated at</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider d-none">
                                @foreach($data as $index => $row)
                                <tr>
                                    <th scope="row">{{$index+1}}</th>
                                    <td style="text-align: center;vertical-align: baseline;">{{$row['episode']}}</td>
                                    <td>
                                        @foreach ($row['link'] as $index => $row)
                                        <button type="button" class="btn btn-primary" data-mdb-toggle="modal"
                                            data-mdb-target="#linkModal-{{$index+1}}">
                                            Show Link {{$index+1}}
                                        </button>
                                        <div class="modal fade" id="linkModal-{{$index+1}}" tabindex="-1"
                                            aria-labelledby="titlemodal-{{$index+1}}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" style="max-width: 100%;width: auto !important;display: table;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="titlemodal-{{$index+1}}">Link
                                                            {{$index+1}}</h5>
                                                        <button type="button" class="btn-close" data-mdb-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! html_entity_decode($row['link']) !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-mdb-dismiss="modal">Close</button>
                                                        {{-- <button type="button" class="btn btn-primary">Save
                                                            changes</button> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </td>
                                    <td>{{$row['view']}}</td>
                                    <td>{{$row['like']}}</td>
                                    <td>{{$row['dislike']}}</td>
                                    <td>{{$row['created_at']}}</td>
                                    <td>{{$row['updated_at']}}</td>
                                    <td>
                                        <button onClick="routeEdit({{$row['id']}})" type="button"
                                            class="btn btn-primary">Edit</button>
                                        <button onClick="routeDelete({{$row['id']}})" type="button"
                                            class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @include('layouts.loading')
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="add_modal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModal">Add Link</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="inner_modal">
                                    <div class="mb-3 col-md-12 col-xs-12 col-sm-12">
                                        <label for="id_detail" class="form-label">id detail</label>
                                        <div class="skeleton skeleton-text skeleton-text__body"></div>
                                        <input type="text" name="idDetail" class="form-control d-none" id="id_detail"
                                            value="{{$detail_movie_id}}">
                                    </div>
                                    <div class="row col-md-12 col-xs-12 col-sm-12">
                                        <div class="col-md-10 col-xs-10 col-sm-10">
                                            <label for="title" class="form-label">Link 1</label>
                                            <div class="skeleton skeleton-text skeleton-text__body"></div>
                                            <input type="text" name="link" class="form-control d-none" id="link_1"
                                                value="">
                                        </div>
                                        <div class="col-md-2 col-xs-2 col-sm-2">
                                            <button type="button" id="add_link_btn" class="btn btn-primary btn-floating"
                                                style="margin-top: 2.07rem"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap5.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#detail_movie').DataTable({
            "columnDefs": [
                { "width": "50%", "targets": 2 }
            ],
            scrollX : true
        });

        $('#loading').hide();
        $('.skeleton').hide();
        $("input[name='link']").removeClass("d-none");
        $("input[name='idDetail']").removeClass("d-none");
        $('#detail_movie tbody').removeClass('d-none');

        $("#add_link_btn").click(function (){
            const getCount = $('#inner_modal input[name="link"]').length + 1;
            $("#inner_modal").append(`
                <div class="row col-md-12 col-xs-12 col-sm-12 link_input_field" id="link_${getCount}">
                    <div class="col-md-10 col-xs-10 col-sm-10">
                        <label for="title" class="form-label">Link ${getCount}</label>
                        <input type="text" name="link" class="form-control" id="${getCount}"
                            value="">
                    </div>
                    <div class="col-md-2 col-xs-2 col-sm-2">
                        <button type="button" class="btn btn-danger btn-floating delete_link_btn"
                            style="margin-top: 2.07rem"><i class="fa-solid fa-minus"></i></button>
                    </div>
                </div>
            `)
        });

        $('#add_modal').on('click', '.delete_link_btn', function() {
            $(this).closest('.link_input_field').remove();
        })
    });
</script>
