@extends('admin.home')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Daftar Siswa</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Siswa</button>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(function() {
            $('.alert').alert('close');
        }, 3000);
    </script>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="thead-dark"> 
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Siswa</th>
                <th class="text-center">NIS</th>
                <th class="text-center">Kelas</th>
                <th class="text-center">Sekolah</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $student->name }}</td>
                    <td class="text-center">{{ $student->nis }}</td>
                    <td class="text-center">{{ $student->classroom->class_name }}</td>
                    <td class="text-center">{{ $student->school->name }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $student->id }}">Edit</button>
                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $student->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $student->id }}">Edit Siswa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Nama Siswa</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nis">NIS</label>
                                        <input type="text" class="form-control" id="nis" name="nis" value="{{ $student->nis }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="classroom_id">Kelas</label>
                                        <select class="form-control" id="classroom_id" name="classroom_id" required>
                                            <option value="">Pilih Kelas</option>
                                            @foreach ($classes as $classroom)
                                                <option value="{{ $classroom->id }}" {{ $classroom->id == $student->classroom_id ? 'selected' : '' }}>{{ $classroom->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="school_id">Sekolah</label>
                                        <select class="form-control" id="school_id" name="school_id" required>
                                            <option value="">Pilih Sekolah</option>
                                            @foreach ($schools as $school)
                                                <option value="{{ $school->id }}" {{ $school->id == $student->school_id ? 'selected' : '' }}>{{ $school->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Foto Siswa</label>
                                        <input type="file" class="form-control" id="photo" name="photo">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Alamat</label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ $student->address }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="parent_name">Nama Orang Tua</label>
                                        <input type="text" class="form-control" id="parent_name" name="parent_name" value="{{ $student->parent_name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="parent_contact">Kontak Orang Tua</label>
                                        <input type="text" class="form-control" id="parent_contact" name="parent_contact" value="{{ $student->parent_contact }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="emergency_contact">Kontak Darurat</label>
                                        <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="{{ $student->emergency_contact }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="classroom_id">Kelas</label>
                                        <select class="form-control" id="classroom_id" name="classroom_id" required>
                                            <option value="">Pilih Kelas</option>
                                            @foreach ($classes as $classroom)
                                                <option value="{{ $classroom->id }}" {{ $classroom->id == $student->classroom_id ? 'selected' : '' }}>{{ $classroom->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Siswa</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" required>
                    </div>
                    <div class="form-group">
                        <label for="classroom_id">Kelas</label>
                        <select class="form-control" id="classroom_id" name="classroom_id" required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($classes as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="school_id">Sekolah</label>
                        <select class="form-control" id="school_id" name="school_id" required>
                            <option value="">Pilih Sekolah</option>
                            @foreach ($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="photo">Foto Siswa</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="parent_name">Nama Orang Tua</label>
                        <input type="text" class="form-control" id="parent_name" name="parent_name" required>
                    </div>
                    <div class="form-group">
                        <label for="parent_contact">Kontak Orang Tua</label>
                        <input type="text" class="form-control" id="parent_contact" name="parent_contact" required>
                    </div>
                    <div class="form-group">
                        <label for="emergency_contact">Kontak Darurat</label>
                        <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" required>
                    </div>
                    <div class="form-group">
                        <label for="pickup_name">Nama Penjemput</label>
                        <input type="text" class="form-control" id="pickup_name" name="pickup_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah Siswa</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
