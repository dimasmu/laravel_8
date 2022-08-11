<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
<link href="{{asset('css/datatables.min.css')}}" rel="stylesheet">
<div class="container-fluid p-0" id="container">
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card flex-fill w-100">
                <div class="card-header" style="background-color: white;">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4" role="group" aria-label="Add">
                        <button type="button" class="btn btn-primary" id="add-btn"><i class="fa-solid fa-plus me-2"></i>
                            Add data
                        </button>
                        <a class="btn btn-warning" onclick="routeBack({{$movieId}})"><i
                                class="fa-solid fa-backward-step me-2"></i>Back</a>
                    </div>
                    <div class="row">
                        <table class="table diplay nowrap" style="width: 100%;overflow: auto;" id="link_movie">
                            <thead>
                                <tr>
                                    <th scope="col" class="width-th">No</th>
                                    <th scope="col">link</th>
                                    <th scope="col">created at</th>
                                    <th scope="col">updated at</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider"></tbody>
                        </table>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="add_modal" aria-labelledby="addModal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModal">Add Link</h5>
                                </div>
                                <form class="modal-body" id="inner_modal">
                                    @csrf
                                    <div class="mb-3 col-md-12 col-xs-12 col-sm-12 d-none">
                                        <label for="movie_id" class="form-label">movie id</label>
                                        <input type="text" name="movieId" class="form-control" id="movie_id"
                                            value="{{$movieId}}">
                                    </div>
                                    <div class="col-md-5 col-xs-12 col-sm-12">
                                        <label for="resolution" class="form-label">Resolution</label>
                                        <select class="form-select js-example-responsive resolution"
                                            style="width: 100%;display: none" name="resolution">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-12 col-xs-12 col-sm-12 d-none">
                                        <label for="detail_id" class="form-label">detail id</label>
                                        <input type="text" name="detailId" class="form-control" id="detail_id"
                                            value="{{$id}}">
                                    </div>
                                    <div class="mb-3 col-md-12 col-xs-12 col-sm-12 d-none">
                                        <label for="link_id" class="form-label">link id</label>
                                        <input type="text" name="linkId" class="form-control" id="link_id"
                                            value="">
                                    </div>
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <label for="embed" class="form-label">Embed</label>
                                        <input type="text" name="embed" class="form-control" id="embed_id" value="">
                                    </div>
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <label for="link_name" class="form-label">Link</label>
                                        <input type="text" name="link" class="form-control" id="link_name" value="">
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" id="dissmis-btn"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="link_button" class="btn btn-primary">Submit</button>
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
<script src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
    var tableLink = null;
    $(document).ready(function () {
        let linkId = {!! isset($id) ? json_encode($id) : 'false' !!};
        let urlReplace = "{{ route('api.link_movie',[':id'])}}".replace(':id', linkId);
        tableLink = $('#link_movie').DataTable({
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
                    "render": function ( data, type, full, meta ) {
                        let createHtml = '';
                        var divArea = document.createElement('textarea');
                        divArea.innerHTML = full.link_embed_resolution;
                        createHtml+=divArea.value;
                        return createHtml;
                    },
                    "data" : null,
                    "target" : [1]
                },
                {
                    "data" : 'created_at',
                    "target" : [2]
                },
                {
                    "data" : 'updated_at',
                    "target" : [3]
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
                    "target" : [4]
                }
            ],
        });

        $('#add-btn').click(function() {
            $('#add_modal').modal('show');
            $('#embed_id').val('');
            $('#link_name').val('');
            $(".resolution").empty().trigger('change');
        })

        $('.resolution').select2({
            dropdownParent: $('#add_modal'),
            allowClear: true,
            placeholder: 'Input resolution',
            ajax: {
                dataType: 'json',
                url: '/api/standard-field-ajax/4',
                delay: 800,
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function (data, page) {
                return {
                    results: data
                };
                },
            }
        }).on('select2:select', function (evt) {
            var data = $(".resolution option:selected").text();
        });

        $('#dissmis-btn').click(function() {
            $('#add_modal').modal('hide');
        })

        $("#link_button").click(function() {
            swal({
                title: "Are you sure to save?",
                showCancelButton: true,
                icon: "warning",
                buttons: true,
                dangerMode: true
            })
            .then((next) => {
                if (next) {
                    // $('#submit_button').html('Sending..');
                    let dataSerialize = $('#inner_modal').serializeArray();
                    let linkId = {!! isset($id) ? json_encode($id) : 'false' !!};
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: dataSerialize, //function yang dipakai agar value pada form-control seperti input, textarea, select dll dapat digunakan pada URL query string ketika melakukan ajax request
                        url: "/link/"+linkId, //url simpan data
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
                                tableLink.ajax.reload();
                                $('#add_modal').modal('hide');
                            })
                        },
                        error: function (data) { //jika error tampilkan error pada console
                            swal({
                                title: "Error Insert!",
                                text: data.responseJSON.message,
                                icon: "error"
                            });
                            console.log('Error:', data);
                        }
                    });
                } else {

                }
            })
        });

    })

    function routeBack(id){
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

    function routeEditLink(id){
        let urlReplace = "{{ route('link.findOne',[':id'])}}".replace(':id', id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: id,
            url: urlReplace,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                console.log("tes");
                $("#add_modal").modal("show");
                $("#link_id").val(id);
                $("#link_name").val(data.link);
                $("#id_episode").val(data.episode);
                $("#embed_id").val(data.embed);
                var resolutionSelect = $(".resolution");
                $.ajax({
                    type: 'GET',
                    url: '/api/standard-field-detail-ajax/'+data.resolution
                }).then(function (data) {
                    // create the option and append to Select2
                    var option = new Option(data.text, data.id, true, true);
                    resolutionSelect.append(option).trigger('change');

                    // manually trigger the `select2:select` event
                    resolutionSelect.trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                });
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

    function routeDeleteLink(id){
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
                    url: "/link/"+id,
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
                            tableLink.ajax.reload();
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

</html>
