<head>
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
</head>
<div class="container-fluid p-0">
    <div class="col-xl-12 col-xxl-12">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Add Movie</h5>
            </div>
            <div class="card-body px-4 col-md-10 col-xs-12 col-sm-12 center-form">
                <div class="row">
                    <form id="insert_movie">
                        @csrf
                        @if (isset($is_update))
                        <div class="mb-3 col-md-10 col-xs-12 col-sm-12 d-none">
                            <label for="title" class="form-label">Id</label>
                            <div class="skeleton skeleton-text skeleton-text__body"></div>
                            <input type="text" name="id" class="form-control d-none" id="title" value="{{$data->id}}">
                        </div>
                        @endif
                        <div class="mb-3 col-md-10 col-xs-12 col-sm-12">
                            <label for="title" class="form-label">Title</label>
                            <div class="skeleton skeleton-text skeleton-text__body"></div>
                            <input type="text" name="title" class="form-control d-none" id="title" value="{!! !empty($data->title) ? $data->title : '' !!}">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5 col-xs-12 col-sm-12">
                                <label for="category" class="form-label">Category</label>
                                <div class="skeleton skeleton-text skeleton-text__body"></div>
                                <select class="form-select js-example-responsive category"
                                    style="width: 100%;display: none" name="category[]" multiple="multiple">
                                    @foreach ($dataGenre as $item)
                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5 col-xs-12 col-sm-12">
                                <label for="release_date" class="form-label">Release Date</label>
                                <div class="form-outline release-date">
                                    <input type="text" class="form-control" name="releaseDate" disabled value="{!! !empty($data->release) ? date('d F Y', strtotime($data->release)) : '' !!}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5 col-xs-12 col-sm-12">
                                <label for="aired_from" class="form-label">Aired From</label>
                                <div class="skeleton skeleton-text skeleton-text__body"></div>
                                <div class="form-outline aired-from-date">
                                    <input type="text" class="form-control d-none" name="airedFrom" disabled value="{!! !empty($data->aired_from) ? date('d F Y', strtotime($data->aired_from)) : '' !!}"/>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-12 col-sm-12">
                                <label for="aired_to" class="form-label">Aired To</label>
                                <div class="skeleton skeleton-text skeleton-text__body"></div>
                                <div class="form-outline aired-to-date">
                                    <input type="text" class="form-control d-none" name="airedTo" disabled value="{!! !empty($data->aired_to) ? date('d F Y', strtotime($data->aired_to)) : '' !!}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5 col-xs-12 col-sm-12">
                                <label for="status" class="form-label">Status</label>
                                <div class="skeleton skeleton-text skeleton-text__body"></div>
                                <select class="form-select js-example-responsive status d-none" name="status"
                                    style="width: 100%">
                                    <option></option>
                                    @foreach ($dataStatus as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5 col-xs-12 col-sm-12">
                                <label for="duration" class="form-label">Duration</label>
                                <div class="skeleton skeleton-text skeleton-text__body"></div>
                                <select class="form-select js-example-responsive duration d-none" name="duration"
                                    style="width: 100%">
                                    <option></option>
                                    @foreach ($dataDuration as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-10 col-xs-5 col-sm-5" role="group" aria-label="Basic example">
                            <a id="submit_button" role="button" class="btn btn-primary me-3"><i
                                    class="fa-solid fa-floppy-disk me-2"></i>Submit</a>
                            <a class="btn btn-warning" onclick="location.href = '{{ url('/movie') }}';"><i
                                    class="fa-solid fa-backward-step me-2"></i>Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('js/moment.js')}}"></script>
<script src="{{asset('js/sweetalert.min.js')}}"></script>
<script>
    $(document).ready(function() {
        let releaseDate = {!! isset($data->release) ? json_encode($data->release) : 'false' !!};
        let dataCategory = {!! isset($data->category) ? json_encode($data->category) : 'false' !!};
        let dataDuration = {!! isset($data->duration) ? json_encode($data->duration) : 'false' !!};
        let dataStatus = {!! isset($data->status) ? json_encode($data->status) : 'false' !!};
        if(dataCategory){
            $(".category").val(dataCategory);
        }
        if(dataDuration){
            $(".duration").val(dataDuration);
        }
        if(dataStatus){
            $(".status").val(dataStatus);
        }
        $('.skeleton').hide();
        // $("input[name='releaseDate']").removeClass("d-none");
        $("input[name='airedTo']").removeClass("d-none");
        $("input[name='airedFrom']").removeClass("d-none");
        $("input[name='title']").removeClass("d-none");
        $("input[name='status']").removeClass("d-none");
        $("input[name='duration']").removeClass("d-none");
        $('.category').select2();
        $('.status').select2({
            allowClear: true,
            placeholder: "Search status"
        });
        $('.duration').select2({
            allowClear: true,
            placeholder: "Search duration"
        });
    });
    const releaseDate = document.querySelector('.release-date');
    new mdb.Datepicker(releaseDate, {
        format: 'dd mmmm yyyy'
    });
    const airedFrom = document.querySelector('.aired-from-date');
    new mdb.Datepicker(airedFrom, {
        format: 'dd mmmm yyyy'
    });
    const airedTo = document.querySelector('.aired-to-date');
    new mdb.Datepicker(airedTo, {
        format: 'dd mmmm yyyy'
    });
    let statusUpdate = {!! isset($is_update) ? json_encode($is_update) : 'false' !!};
    let titleSwal = 'Are you sure to insert?';
    if(statusUpdate === true){
        titleSwal = 'Are you sure to update?'
    }
$("#submit_button").click(function() {
    swal({
        title: titleSwal,
        showCancelButton: true,
        icon: "warning",
        buttons: true,
        dangerMode: true
    })
    .then((next) => {
        if (next) {
             // $('#submit_button').html('Sending..');
            let dataSerialize = $('#insert_movie').serializeArray();
            let releaseDate = $("input[name='releaseDate']").val() !== '' ? moment($("input[name='releaseDate']").val()).format('YYYY-MM-DD') : null;
            let airedFrom = $("input[name='airedFrom']").val() !== '' ? moment($("input[name='airedFrom']").val()).format('YYYY-MM-DD') : null;
            let airedTo = $("input[name='airedTo']").val() !== '' ? moment($("input[name='airedTo']").val()).format('YYYY-MM-DD') : null;
            dataSerialize.push({name: 'release',value: releaseDate});
            dataSerialize.push({name: 'aired_from',value: airedFrom});
            dataSerialize.push({name: 'aired_to',value: airedTo});
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: dataSerialize, //function yang dipakai agar value pada form-control seperti input, textarea, select dll dapat digunakan pada URL query string ketika melakukan ajax request
                url: "{{ route('insert_movie') }}", //url simpan data
                type: "POST", //karena simpan kita pakai method POST
                dataType: 'json', //data tipe kita kirim berupa JSON
                success: function (data) { //jika berhasil
                    swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        buttons: false,
                        timer: 800
                    }).then( function () {
                        location.href = "{{route('movie')}}";
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
</script>
