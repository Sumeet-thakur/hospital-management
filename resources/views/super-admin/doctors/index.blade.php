@extends('layouts.adminlte')

@section('title', 'Manage Doctors')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">Doctors List</h3>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary btn-sm float-right">
            <i class="fas fa-plus"></i> Add Doctor
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered datatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Specialization</th>
                    <th>Fee</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctors as $doctor)
                <tr>
                    <td>{{ $doctor->id }}</td>
                    <td>{{ $doctor->name }}</td>
                    <td>{{ $doctor->email }}</td>
                    <td>{{ $doctor->phone }}</td>
                    <td>{{ $doctor->specialization }}</td>
                    <td>Rs{{ $doctor->consultation_fee }}</td>
                    <td>
                        <span class="badge badge-{{ $doctor->status == 'active' ? 'success' : 'danger' }}">
                            {{ $doctor->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection