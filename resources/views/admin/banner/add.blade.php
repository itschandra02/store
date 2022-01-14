@extends('admin.layouts.layout')
@section('title')
    @if ($data)
        Edit
    @else
        Add
    @endif Banner
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="" class="floating-labels pt-2" id="frmAdd" name="frmAdd" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="text" name="id" id="id" readonly class="form-control" @if ($data)
                                value="{{ $data->id }}"
                                @endif>
                                <span class="bar"></span>
                                <label for="id">ID</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="title" name="title" @if ($data)
                                value="{{ $data->title }}"
                                @endif>
                                <span class="bar"></span>
                                <label for="title">Title</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="description" name="description" @if ($data)
                                value="{{ $data->description }}"
                                @endif>
                                <span class="bar"></span>
                                <label for="description">Description</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="link" name="link" @if ($data)
                                value="{{ $data->link }}"
                                @endif>
                                <span class="bar"></span>
                                <label for="link">Link</label>
                            </div>
                            <div class="form-group">
                                <input type="file" id="image" class="dropify" name="image" @if ($data)
                                data-default-file="{{ $data->img }}"
                                @endif />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary float-right">
                                    Add +
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script src="{{ asset('assets/admin/assets/plugins/dropify/dist/js/dropify.min.js') }}"></script>
    <script defer>
        $(document).ready(function() {
            $('.dropify').dropify();
            $("#frmAdd").submit(function(e) {
                e.preventDefault();

                var frmData = new FormData();
                frmData.append("id", $("input#id").val());
                frmData.append("link", $("input#link").val());
                frmData.append("title", $("input#title").val());
                frmData.append("description", $("input#description").val());
                frmData.append("image", $("#image")[0].files[0]);
                console.log(frmData)

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.banner.add') }}",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: frmData,
                    success: function(resp) {
                        // resetFormEdit();
                        window.location = "?id=" + resp.id;
                    }
                })
            });
        })
    </script>
@endsection
