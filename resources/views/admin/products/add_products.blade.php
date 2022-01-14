@extends('admin.layouts.layout')
@section('title')
    Add or Edit Products
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-lg-9 mt-4">
            <div class="card shadow">
                <div class="card-body b-b">
                    <form action="" class="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-5">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">ID</label>
                                        <input type="text" class="form-control" readonly id="id"
                                            @if ($data) value="{{ $data->id }}" @endif />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            @if ($data) value="{{ $data->name }}" @endif />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Subtitle</label>
                                        <input type="text" class="form-control" name="subtitle" id="subtitle"
                                            @if ($data) value="{{ $data->subtitle }}" @endif>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <textarea id="description" name="description">@if ($data){{ $data->description }}@endif</textarea>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="file">Thumbnail</label>
                                <input type="file" class="dropify" id="file" aria-describedby="inputGroupFileAddon01"
                                    @if ($data)data-default-file="{{ $data->thumbnail }}"@endif>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="file2" class="form-label">Instruction</label>
                                <input type="file" class="dropify" id="file2" name="file2"
                                    accept=".jpg, .webp, .jpeg" aria-describedby="inputGroupFileAddon01"
                                    @if ($data)data-default-file="{{ $data->instruction }}"@endif>
                            </div>
                            <div class="col-lg-8 mt-4">
                                <div class="form-group">
                                    <label for="type">Category</label>
                                    <select name="category" id="category" class="form-control p-0">
                                        @php
                                            $_categories = json_decode(json_encode($categories), 1);
                                            $_categories[] = [
                                                'name' => 'regular',
                                                'title' => 'Regular',
                                            ];
                                        @endphp
                                        @foreach ($_categories as $category)
                                            <option value="{{ $category['name'] }}" @if ($data)
                                                @if ($data->category == $category['name'])
                                                    selected
                                                @endif

                                        @endif>{{ $category['title'] }}</option>
                                        @endforeach
                                    </select><span class="bar"></span>
                                </div>
                            </div>
                            <div class="col-lg-5 mt-3">
                                <div class="form-group">
                                    <div class="form-check">
                                        <div class="switch">
                                            <label>Use Input OFF<input id="useInput" name="useInput" type="checkbox" /><span
                                                    class="lever"></span>ON</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-primary" onclick="publish();">Publish</button>
                        </div>
                    </div>
                    @if ($data)
                        <div class="row">
                            <div class="col mt-2">
                                <a href="{{ route('order_page', $data->slug) }}" class="btn btn-success"
                                    target="_blank">View
                                    <i class="fas fa-external-link-alt"></i></a>
                                <p>Updated at <br>{{ $data->updated_at }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-9 mt-4 collapse" id="collapseExample">
            <div class="card shadow">
                <div class="card-body">
                    <form action="" class="floating-labels m-t-40">
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <select name="type" id="type" class="form-control p-0">
                                    <option value="number">Number</option>
                                    <option value="text">Text</option>
                                    <option value="password">Password</option>
                                </select><span class="bar"></span>
                                <label for="type">Type</label>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="name" name="name"
                                            autocomplete="off" />
                                        <label class="form-label">Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="value" name="value"
                                            autocomplete="off" />
                                        <label class="form-label">Value</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="placeholder" name="placeholder"
                                            autocomplete="off" />
                                        <label class="form-label">Placeholder</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-12 float-right">
                            <button class="btn btn-primary" onclick="addItem()">Add</button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <table class="table" id="tblInput"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script src="{{ asset('assets/admin/assets/plugins/dropify/dist/js/dropify.min.js') }}"></script>
    <script>
        var ITEMS =
            @if ($items)
                @json($items);
            @else
                [];
            @endif
        var useInput = 0;
        $(document).ready(() => {
            $('.dropify').dropify();
            $('#description').summernote();
            $("input#useInput").change(function() {
                $("#collapseExample").collapse("toggle");
                useInput = this.checked ? 1 : 0;
            })
            @if ($data)
                @if ($data->use_input == 1)
                    $("input#useInput").trigger("click")
                @endif
            @endif
            $("input#file").change(function() {
                $("label[for='file']").text($("input#file")[0].files[0].name);
            })
            initTable()
        })

        function initTable() {
            $("#tblInput").bootstrapTable('destroy').bootstrapTable({
                data: ITEMS,
                columns: [{
                        title: "Name",
                        field: "name"
                    },
                    {
                        title: "Value",
                        field: "value"
                    },
                    {
                        title: "Type",
                        field: "type"
                    },
                    {
                        title: "Placeholder",
                        field: "placeholder"
                    },
                    {
                        title: "Action",
                        events: window.operateEvents,
                        formatter: (value, row, index) => {
                            return `
                                                    <a id="rowDelete" class="badge badge-danger badge-pill" href="javscript:void(0);"><i class="fas fa-trash"></i></a>
                                                    `
                        }
                    }
                ]
            })
        }
        window.operateEvents = {
            "click #rowDelete": (e, value, row, index) => {
                ITEMS.splice(index, 1);
                initTable()
            }
        }

        function addItem() {
            let _item = {
                name: $("#name").val(),
                value: $("#value").val(),
                placeholder: $("#placeholder").val(),
                type: $("select#type option:selected").val()
            }
            ITEMS.push(_item);
            initTable();
        }

        function publish() {
            var frmData = new FormData();
            frmData.append("id", $("input#id").val());
            frmData.append("title", $("input#title").val());
            frmData.append("subtitle", $("input#subtitle").val());
            frmData.append("description", $("#description").summernote('code'));
            frmData.append("thumbnail", $("#file")[0].files[0]);
            frmData.append("instruction", $("#file2")[0].files[0]);
            frmData.append("items", JSON.stringify(ITEMS))
            frmData.append("category", $("#category option:selected").val());
            frmData.append("use_input", useInput);
            $.ajax({
                type: "POST",
                url: "{{ route('prod.add') }}",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: frmData,
                beforeSend: (r) => {
                    Swal.fire('Loading...');
                    Swal.showLoading();
                },
                success: function(resp) {
                    // resetFormEdit();
                    Swal.fire({
                        title: 'Disimpan!',
                        text: 'Product telah disimpan.',
                        icon: 'success',
                    }).then((result) => {
                        window.location = "?id=" + resp.id;
                    })
                }
            })
        }
    </script>
@endsection
