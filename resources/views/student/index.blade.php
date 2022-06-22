<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Laravel Ajax CRUD</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">​
</head>

<body>
    <div class="container">
        <a href="#" class="btn btn-success btn-add" data-target="#modal-add" data-toggle="modal">Add</a>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td id="hoten-{{ $student->id }}">{{ $student->id }}</td>
                            <td id="hoten-{{ $student->id }}">{{ $student->hoten }}</td>
                            <td id="gioitinh-{{ $student->id }}">{{ $student->gioitinh }}</td>
                            <td id="ngaysinh-{{ $student->id }}">{{ $student->ngaysinh }}</td>
                            <td id="sdt-{{ $student->id }}">{{ $student->sdt }}</td>
                            <td id="diachi-{{ $student->id }}">{{ $student->diachi }}</td>
                            <td>
                                <button data-url="{{ route('studentajax.show', $student->id) }}"​ type="button"
                                    data-target="#show" data-toggle="modal"
                                    class="btn btn-info btn-show">Detail</button>
                                <button data-url="{{ route('studentajax.update', $student->id) }}"​ type="button"
                                    data-target="#edit" data-toggle="modal"
                                    class="btn btn-warning btn-edit">Edit</button>
                                <button data-url="{{ route('studentajax.destroy', $student->id) }}"​ type="button"
                                    data-target="#delete" data-toggle="modal"
                                    class="btn btn-danger btn-delete">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('student.add')
    @include('student.detail')
    @include('student.edit')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js">
    </script>
    <script type="text/javascript" charset="utf-8">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#form-add').submit(function(e) {
                e.preventDefault();
                var url = $(this).attr('data-url');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        hoten: $('#hoten-add').val(),
                        gioitinh: $('#gioitinh-add').val(),
                        ngaysinh: $('#ngaysinh-add').val(),
                        sdt: $('#sdt-add').val(),
                        diachi: $('#diachi-add').val(),
                    },
                    success: function(response) {
                        toastr.success(response.message)
                        $('#modal-add').modal('hide');
                        console.log(response.data)
                        $('tbody').prepend('<tr><td id="' + response.data.id + '">' + response
                            .data.id + '</td><td id="hoten-' + response.data.id + '">' +
                            response.data.hoten + '</td><td id="gioitinh-' + response.data
                            .id + '">' + response.data.gioitinh + '</td><td id="ngaysinh-' +
                            response.data.id + '">' + response.data.ngaysinh +
                            '</td><td id="sdt-' + response.data.id + '">' + response.data
                            .sdt + '</td><td id="diachi-' + response.data.id + '">' +
                            response.data.diachi +
                            '</td><td><button data-url="{{ asset('') }}studentajax/' +
                            response.data.id +
                            '"​ type="button" data-target="#show" data-toggle="modal" class="btn btn-info btn-show">Detail</button><button style="margin-left: 5px;" data-url="{{ asset('') }}studentajax/' +
                            response.data.id +
                            '"​ type="button" data-target="#edit" data-toggle="modal" class="btn btn-warning btn-edit">Edit</button><button style="margin-left: 5px;" data-url="{{ asset('') }}studentajax/' +
                            response.data.id +
                            '"​ type="button" data-target="#delete" data-toggle="modal" class="btn btn-danger btn-delete">Delete</button></td></tr>'
                            );
                    },
                    error: function(error) {
                        toastr.error('Thêm student thất bại!');

                    }
                })
            })

            $('.btn-show').click(function() {
                var url = $(this).attr('data-url');
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $('#id').text(response.data.id)
                        $('#hoten').text(response.data.hoten)
                        $('#gioitinh').text(response.data.gioitinh)
                        $('#ngaysinh').text(response.data.ngaysinh)
                        $('#sdt').text(response.data.sdt)
                        $('#diachi').text(response.data.diachi)
                        $('#created_at').text(response.data.created_at)
                        $('#update_at').text(response.data.update_at)
                    },
                    error: function(error) {
                        toastr.error('Hiển thị student thất bại!');
                    }
                })
            })

            $('.btn-edit').click(function(e) {
                var url = $(this).attr('data-url');
                $('#modal-edit').modal('show');
                e.preventDefault();
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        //lấy dữ liệu từ controller điền vào input form edit
                        $('#hoten-edit').val(response.data.hoten);
                        $('#ngaysinh-edit').val(response.data.ngaysinh);
                        $('#gioitinh-edit').val(response.data.gioitinh);
                        $('#sdt-edit').val(response.data.sdt);
                        $('#diachi-edit').val(response.data.diachi);
                        //thêm data-url route edit được chỉ định vào form edit
                        $('#form-edit').attr('data-url', '{{ asset('studentajax/') }}/' +
                            response.data.id)
                    },
                    error: function(error) {
                        toastr.error('Sửa student thất bại!');
                    }
                })
            })

            $('#form-edit').submit(function(e) {
                e.preventDefault();
                var url = $(this).attr('data-url');
                $.ajax({
                    type: 'PUT',
                    url: url,
                    data: {
                        hoten: $('#hoten-edit').val(),
                        gioitinh: $('#gioitinh-edit').val(),
                        ngaysinh: $('#ngaysinh-edit').val(),
                        sdt: $('#sdt-edit').val(),
                        diachi: $('#diachi-edit').val(),
                    },
                    success: function(response) {
                        toastr.success(response.message)
                        $('#modal-edit').modal('hide');
                        $('#hoten-' + response.studentid).text(response.student.hoten)
                        $('#gioitinh-' + response.studentid).text(response.student.gioitinh)
                        $('#ngaysinh-' + response.studentid).text(response.student.ngaysinh)
                        $('#sdt-' + response.studentid).text(response.student.sdt)
                        $('#diachi-' + response.studentid).text(response.student.diachi)
                    },
                    error: function() {
                        toastr.error('Sửa student thất bại!');
                    }
                })
            })

            $('.btn-delete').click(function() {
                var url = $(this).attr('data-url');
                var _this = $(this);
                if (confirm('Bạn có chắc muốn xóa không?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        success: function(response) {
                            toastr.success('Xóa student thành công!')
                            _this.parent().parent().remove();
                        },
                        error: function() {
                            toastr.error('Xóa student thất bại!');
                        }
                    })
                }
            })
        })
    </script>
</body>

</html>​
