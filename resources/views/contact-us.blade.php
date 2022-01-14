@extends('layouts.layout')
@section('title')
    Hubungi kami
@endsection
@section('body')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto mt-5 mb-5">
                <div class="card bg-dark shadow">
                    <div class="card-header">
                        <h5>Hubungi kami</h5>
                    </div>
                    <div class="card-body">
                        <form action="" id="frmContact" enctype="multipart/form-data">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="type">Tipe</label>
                                    <select name="type" id="type" class="form-select">
                                        <option value="-">Pilih tipe</option>
                                        <option value="masalah">Masalah Order</option>
                                        <option value="payment">Salah menuliskan pembayaran</option>
                                        <option value="interest">Ingin membuat web ini?</option>
                                        <option value="feedback">Feedback</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-7">
                                    <label for="username">Nama:</label>
                                    <input type="text" name="username" placeholder="Nama/Username" id="username"
                                        class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-7">
                                    <label for="phonenum">Nomor Whatsapp:</label>
                                    <input type="text" name="phonenum" placeholder="6285xxxx" id="phonenum"
                                        class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-2 " id="_invoiceNumber">
                                <div class="col-md-7">
                                    <label for="invoiceNumber">Nomor Pembayaran:</label>
                                    <input type="text" name="invoiceNumber" placeholder="Nomor Pembayaran"
                                        id="invoiceNumber" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="description">Deskripsi</label>
                                    <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                                        autocomplete="off" placeholder="Deskripsi"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2 " id="_attachment">
                                <div class="col">
                                    <label for="attachment">Attachment</label>
                                    <input type="file" name="attachment" id="attachment" class="form-control"
                                        autocomplete="off" accept="image/*">
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-success float-end" onclick="sendForm()">Kirim! <i
                                        class="fas fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        (() => {
            $("#_invoiceNumber").hide();
            $("#_attachment").hide();
            $("#frmContact").submit((e) => e.preventDefault())
        })()

        $(document).ready(function() {
            $("#type").change(() => {
                $("#_invoiceNumber").hide();
                $("#_attachment").hide();
                switch ($("#type option:selected").val()) {
                    case "masalah":
                        $("#_invoiceNumber").show()
                        break;
                    case "payment":
                        $("#_invoiceNumber").show()
                        $("#_attachment").show();
                        break;
                    default:
                        break;
                }
            })
        })

        function checkk() {
            let value = $("#invnum").val();
            window.location.href = `{{ route('invoice', '') }}/${value}`;
        }

        function sendForm() {
            let frm = new FormData()
            frm.append("type", $("#type option:selected").val())
            frm.append("typeValue", $("#type option:selected").text())
            frm.append("username", $("#username").val())
            frm.append("phonenum", $("#phonenum").val())
            frm.append("invoiceNumber", $("#invoiceNumber").val())
            frm.append("description", $("#description").val())
            frm.append("attachment", $("#attachment")[0].files[0])
            $.ajax({
                url: "{{ route('contact_us.send') }}",
                type: 'POST',
                data: frm,
                contentType: false,
                processData: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                },
                data: frm,
                beforeSend: (r) => {
                    Swal.fire('Loading...');
                    Swal.showLoading();
                },
                success: (res) => {
                    if (res.success) {
                        Swal.fire('Success!', 'Feedback anda sudah terkirim!', 'success')
                    }
                },
                error: (err) => {
                    console.log(err)
                    Swal.fire('Error!', err.responseJSON.message, 'error')
                }
            })
        }
    </script>
@endsection
