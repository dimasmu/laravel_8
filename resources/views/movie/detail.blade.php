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
                        <button type="button" class="btn btn-primary" id="add-btn"><i
                                class="fa-solid fa-plus me-2"></i>
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
                            <tbody class="table-group-divider"></tbody>
                        </table>
                        @include('layouts.loading')
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="add_modal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModal">Add Episode</h5>
                                </div>
                                <form class="modal-body" id="inner_modal">
                                    <div class="mb-3 col-md-12 col-xs-12 col-sm-12 d-none">
                                        <label for="movie_id" class="form-label">movie id</label>
                                        <input type="text" name="movieId" class="form-control" id="movie_id"
                                            value="{{$movie_id}}">
                                    </div>
                                    <div class="mb-3 col-md-12 col-xs-12 col-sm-12 d-none">
                                        <label for="link_id" class="form-label">Link id</label>
                                        <input type="text" name="lnkId" class="form-control" id="link_id" value="">
                                    </div>
                                    <div class="mb-3 col-md-12 col-xs-12 col-sm-12">
                                        <label for="episode" class="form-label">episode</label>
                                        <input type="text" name="episode" class="form-control" id="id_episode"
                                            value="{!! !empty($data->episode) ? $data->episode : null !!}">
                                    </div>
                                    {{-- <div class="row link_input_field">
                                        <div class="col-md-10 col-xs-10 col-sm-10">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <label for="embed_1" class="form-label">Embed 1</label>
                                                <input type="text" name="embed" class="form-control" id="embed_1"
                                                    value="">
                                            </div>
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <label for="link" class="form-label">link 1</label>
                                                <input type="text" name="link" class="form-control" id="link_1"
                                                    value="">
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-2 col-sm-2">
                                            <div class="col-md-2 col-xs-2 col-sm-2" style="margin-top: 65px;">
                                                <button type="button" id="add_link_btn"
                                                    class="btn btn-primary btn-floating"><i
                                                        class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div> --}}
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
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap5.min.js')}}"></script>
<script type="text/javascript">
    var table = null;
    $(document).ready(function () {
        let movieId = {!! isset($movie_id) ? json_encode($movie_id) : 'false' !!};
        let urlReplace = "{{ route('api.detail_movie_index',[':id'])}}".replace(':id', movieId);
        table = $('#detail_movie').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollCollapse: true,
            ajax: urlReplace,
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
                        let createHtml = '';
                        var divArea = document.createElement('textarea');
                        divArea.innerHTML = full.link_html;
                        createHtml+=divArea.value;
                        return createHtml;
                    },
                    "data" : null,
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
                {
                    "render": function ( data, type, full, meta ) {
                        let createHtml = '';
                        var divArea = document.createElement('textarea');
                        divArea.innerHTML = full.action;
                        createHtml+=divArea.value;
                        return createHtml;
                    },
                    "data" : null,
                    "target" : [8]
                },
            ],
        });

        $('#loading').hide();
        $("#add_link_btn").click(function (){
            const getCount = $(`#inner_modal .link_input_field_clone`).length + 2;
            $("#inner_modal").append(`
                <div class="row link_input_field_clone">
                    <div class="col-md-10 col-xs-10 col-sm-10">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label for="title" class="form-label">Embed ${getCount}</label>
                            <input type="text" name="embed_${getCount}" id="embed_${getCount}" class="form-control"
                                value="">
                        </div>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label for="link_${getCount}" class="form-label">link ${getCount}</label>
                            <input type="text" name="link${getCount}" class="form-control" id="link_${getCount}"
                                value="">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-2 col-sm-2">
                        <div class="col-md-2 col-xs-2 col-sm-2" style="margin-top:35px;">
                            <button type="button" class="btn btn-danger btn-floating delete_link_btn"
                                style="margin-top: 2.07rem"><i class="fa-solid fa-minus"></i></button>
                        </div>
                    </div>
                </div>
            `)
        });

        $('#add_modal').on('click', '.delete_link_btn', function() {
            $(this).closest('.link_input_field_clone').remove();
        })

        $('#add-btn').click(function() {
            $('#add_modal').modal('show');
            $('#id_episode').val('');
            $('#embed_1').val('');
            $('#link_1').val('');
            $('#link_id').val('');
            $(this).parent().parent().find('.link_input_field_clone').remove()
        })

        $('#dissmis-btn').click(function() {
            // $('video').get(0).play();
            // $('video').get(0).pause();
            $('#add_modal').modal('hide');
            $(this).parent().parent().find('.link_input_field_clone').remove()
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
                    let arrayPush = [];
                    let object = {};
                    let totalLink = {};
                    arrayPush.push({
                        "embed" : $("#embed_1").val(),
                        "link" : $("#link_1").val()
                    })
                    let clone = $(".link_input_field_clone");
                    for(var i = 0; i < clone.length; i++){
                        var inputValues = $(clone[i]).find(':input').map(function(element,index) {
                            var type = $(this).prop("type");

                            // checked radios/checkboxes
                            if ((type == "checkbox" || type == "radio") && this.checked) {
                                return $(this).val();
                            }
                            // all other fields, except buttons
                            else if (type != "button" && type != "submit") {

                                if(element === 0){
                                    object[`embed`] = $(this).val()
                                }

                                if(element === 1){
                                    object[`link`] = $(this).val()
                                }
                            }
                        })
                        arrayPush.push(object);
                    }
                    totalLink = arrayPush;
                    console.log("total link : ",totalLink);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            "movie_id" : $("#movie_id").val(),
                            "link_id" : $("#link_id").val(),
                            "episode" : $("#id_episode").val(),
                            "total_link" : totalLink
                        },
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
                                $('#add_modal').modal('hide');
                                $("#submit_button").parent().parent().find('.link_input_field_clone').remove();
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

    function routeDeleteDetail(id){
        swal({
            title: 'Are you sure to delete?',
            showCancelButton: true,
            icon: "warning",
            buttons: true,
            dangerMode: true
        })
        .then((next) => {
            if (next) {
                // let urlReplace = "{{ route('detail_movie.delete',[':id'])}}".replace(':id', id);
                $.ajax({
                    url: "/detail-movie/"+id,
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

    function routeEditDetail(id){
        $(("#editBtn_"+id).toString()).parents('.card-header').find('.link_input_field_clone').remove();
        let urlReplace = "{{ route('api.detail_id',[':id'])}}".replace(':id', id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: id,
            url: urlReplace,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                let link = data.get_link;
                $("#add_modal").modal("show");
                $("#link_id").val(id);
                $("#id_episode").val(data.episode);
                // link.map((element,index) => {
                //     if(index === 0){
                //         $("#embed_1").val(element.embed === null ? '' : element.embed);
                //         $("#link_1").val(element.link === null ? '' : element.link);
                //     }else {
                //         const getCount = $(`#inner_modal .link_input_field_clone`).length + 2;
                //         $("#inner_modal").append(`
                //             <div class="row link_input_field_clone">
                //                 <div class="col-md-10 col-xs-10 col-sm-10">
                //                     <div class="col-md-12 col-xs-12 col-sm-12">
                //                         <label for="title" class="form-label">Embed ${getCount}</label>
                //                         <input type="text" name="embed${getCount}" id="embed_${getCount}" class="form-control"
                //                             value="">
                //                     </div>
                //                     <div class="col-md-12 col-xs-12 col-sm-12">
                //                         <label for="link_${getCount}" class="form-label">link ${getCount}</label>
                //                         <input type="text" name="link${getCount}" class="form-control" id="link_${getCount}"
                //                             value="">
                //                     </div>
                //                 </div>
                //                 <div class="col-md-2 col-xs-2 col-sm-2">
                //                     <div class="col-md-2 col-xs-2 col-sm-2" style="margin-top: 35px;">
                //                         <button type="button" class="btn btn-danger btn-floating delete_link_btn"
                //                             style="margin-top: 2.07rem"><i class="fa-solid fa-minus"></i></button>
                //                     </div>
                //                 </div>
                //             </div>
                //         `)
                //         $(`input[name='embed${getCount}']`).val(element.embed === null ? '' : element.embed);
                //         $(`input[name='link${getCount}']`).val(element.link === null ? '' : element.link);
                //     }
                // })
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

    function routeLinkDetail(id,movie_id){
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "get",
            url: "/link/"+id,
            data: {
                "movie_id" : movie_id,
                "CSRF_TOKEN" : CSRF_TOKEN
            },
            success: function (response) {
                $(".content").html(response);
                // window.history.replaceState(null, null, "/link/"+id);
            }
        });
    }

</script>
