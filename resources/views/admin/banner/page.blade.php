@extends('admin.layouts.layout')
@section('title')
    Banner
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card no-b shadow2">
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="toolbar">
                            <a href="{{ route('admin.banner.page.add') }}" class="btn btn-primary">Add + </a>
                        </div>
                        <table id="tblBanner" class="table table-stripped"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#tblBanner").bootstrapTable('destroy').bootstrapTable({
                url: `{{ route('admin.banner.get') }}`,
                toolbar: '#toolbar',
                pagination: true,
                pageSize: 10,
                pageList: [10, 25, 50, 100, 'all'],
                search: true,
                showColumns: true,
                showColumnsToggleAll: true,
                searchHighlightFormatter: true,
                columns: [{
                        title: '#',
                        field: 'id'
                    },
                    {
                        title: 'Image',
                        field: 'img',
                        formatter: (value, row, index) => `<img src="${value}" width="150px"/>`
                    },
                    {
                        title: 'Title',
                        field: 'title'
                    },
                    {
                        title: 'Description',
                        field: 'description'
                    },
                    {
                        title: 'Link',
                        field: 'link',
                        formatter: (value, row, index) => `<a href="${value}">Link</a>`
                    },
                    {
                        title: 'Active',
                        events: {
                            'click input[name="isActive"]': (e, value, row, index) => {
                                $.post("{{ URL::route('admin.banner.event') }}?type=reactivate&id=" +
                                    row
                                    .id, (
                                        res) => {
                                        $("#tblProducts").bootstrapTable('refresh');
                                    })
                            },
                        },
                        formatter: (value, row, index) => {
                            let checked = '';
                            console.log(row)
                            if (row.active) {
                                checked = 'checked'
                            }
                            // let b = `
                        // <div class="material-switch">
                        //     <input id="isActive${index}" name="isActive" type="checkbox" ${checked}/>
                        //     <label for="isActive${index}" class="bg-primary"></label>
                        // </div>
                        // `
                            let b = `
                                <div class="switch">
                                    <label><input id="isActive${index}" name="isActive" type="checkbox" ${checked}><span class="lever"></span></label>
                                </div>
                                `
                            return b
                        }
                    },
                    {
                        title: 'Actions',
                        events: {
                            'click #delete': (e, value, row, index) => {
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('admin.banner.delete') }}",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    data: {
                                        id: row.id
                                    },
                                    success: function(resp) {
                                        // resetFormEdit();
                                        location.reload();
                                    }
                                })
                            }
                        },
                        formatter: (value, row, index) => {
                            let b = `
                                    <a href="{{ route('admin.banner.add') }}?id=${row.id}" class="btn btn-success btn-sm">Edit</a>
                                    <button id="delete" class="btn btn-danger btn-sm">Delete</button>
                                `
                            return b
                        }
                    }
                ]
            })
        })
    </script>
@endsection
