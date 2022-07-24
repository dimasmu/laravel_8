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
                                    {{-- <th scope="col">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody class="table-group-divider d-none"></tbody>
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
                                <form class="modal-body" id="inner_modal">
                                    <div class="mb-3 col-md-12 col-xs-12 col-sm-12">
                                        <label for="movie_id" class="form-label">movie id</label>
                                        <div class="skeleton skeleton-text skeleton-text__body"></div>
                                        <input type="text" name="movieId" class="form-control d-none" id="movie_id"
                                            value="{{$movie_id}}">
                                    </div>
                                    <div class="mb-3 col-md-12 col-xs-12 col-sm-12">
                                        <label for="episode" class="form-label">episode</label>
                                        <div class="skeleton skeleton-text skeleton-text__body"></div>
                                        <input type="text" name="episode" class="form-control d-none" id="id_episode"
                                            value="{!! !empty($data->episode) ? $data->episode : null !!}">
                                    </div>
                                    <div class="row col-md-12 col-xs-12 col-sm-12 link_input_field">
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
                                </form>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
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
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap5.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        console.log("tes");
        let movieId = {!! isset($movie_id) ? json_encode($movie_id) : 'false' !!};
        let urlReplace = "{{ route('api.detail_movie_index',[':id'])}}".replace(':id', movieId);
        var table = $('#detail_movie').DataTable({
            processing: true,
            serverSide: true,
            ajax: urlReplace,
            // columns: [
            //     {data: 'no', name: 'no'},
            //     {data: 'episode', name: 'episode'},
            //     {data: 'view', name: 'view'},
            //     {data: 'like', name: 'like'},
            //     {data: 'dislike', name: 'dislike'},
            //     {data: 'created_at', name: 'created_at'},
            //     {data: 'updated_at', name: 'updated_at'}
            //     // {data: 'action', name: 'action', orderable: false, searchable: false},
            // ]
            columnDefs: [
                {
                    "data" : 'no',
                    "target" : [0]
                },
                {
                    "data" : 'episode',
                    "target" : [1]
                },
                {
                    "render": function ( data, type, full, meta ) {
                            let link = data;
                            let createHtml = '';
                            let getIdHTML = '';
                            link.map((element,index) => {
                                createHtml+=
                                `
                                <button type="button" class="btn btn-primary" data-mdb-toggle="modal"
                                            data-mdb-target="#linkModal-${index+1}">
                                            Show Link ${index+1}
                                        </button>
                                        <div class="modal fade" id="linkModal-${index+1}" tabindex="-1"
                                            aria-labelledby="titlemodal-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" style="max-width: 100%;width: auto !important;display: table;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="titlemodal-${index+1}">Link ${index+1}</h5>
                                                        <button type="button" class="btn-close" data-mdb-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="modalbody-${index+1}">

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
                                `
                                // getIdHTML = createHtml.find(`#modalbody-${index+1}`).append(`${element.link}`);
                            });
                            return createHtml;
                    },
                    "data" : 'link',
                    "target" : [2]
                },
                {
                    "data" : 'view',
                    "target" : [3]
                },
                {
                    "data" : 'like',
                    "target" : [4]
                },
                {
                    "data" : 'dislike',
                    "target" : [5]
                },
                {
                    "data" : 'created_at',
                    "target" : [6]
                },
                {
                    "data" : 'updated_at',
                    "target" : [7]
                },
            ],
        });

        $('#loading').hide();
        $('.skeleton').hide();
        $("input[name='link']").removeClass("d-none");
        $("input[name='episode']").removeClass("d-none");
        $("input[name='movieId']").removeClass("d-none");
        $('#detail_movie tbody').removeClass('d-none');

        $("#add_link_btn").click(function (){
            const getCount = $(`#inner_modal .link_input_field`).length + 1;
            $("#inner_modal").append(`
                <div class="row col-md-12 col-xs-12 col-sm-12 link_input_field">
                    <div class="col-md-10 col-xs-10 col-sm-10">
                        <label for="title" class="form-label">Link ${getCount}</label>
                        <input type="text" name="link_${getCount}" class="form-control"
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

        $("#submit_button").click(function() {
            swal({
                title: "are you sure?",
                showCancelButton: true,
                icon: "warning",
                buttons: true,
                dangerMode: true
            })
            .then((next) => {
                if(next){
                    let dataSerialize = $('#inner_modal').serializeArray();
                    let newData = [];
                    let getMovieId = null;
                    let date = new Date();
                    dataSerialize.map((element,index) => {
                        let getName = element.name;
                        if(getName === 'movieId'){
                            getMovieId = element.value
                        }
                    });
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: dataSerialize,
                        url: "{{ route('detail_movie.save') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) { //jika berhasil
                            swal({
                                title: data.title,
                                text: data.text,
                                icon: "success",
                                buttons: false,
                                timer: 800
                            }).then( function () {
                                const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                table.ajax.reload();
                            })
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
            })
        })
    });



</script>
