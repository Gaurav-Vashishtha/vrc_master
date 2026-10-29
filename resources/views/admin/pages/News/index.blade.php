@extends('admin.template.base')

@section('title', 'News List')

@section('content')
<style>

    .btn-fixed {
    height: 38px;
    min-width: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-control {
    height: 38px;
}

.card-body {
    padding: 25px !important;
}

.form-control {
    min-width: 180px;
    height: 42px;
}

.btn-fixed {
    min-width: 120px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.table-responsive {
    margin-top: 15px;
}

.table th,
.table td {
    padding: 14px 12px;
    vertical-align: middle;
}
    </style>
<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title">News List</h3>

            <a href="{{ route('admin.news.create') }}"
                class="btn btn-success">
                Add News
            </a>
        </div>


        <div class="card">
            <div class="card-body">

                 <div class="card-body">
                        <form method="GET" action="{{ route('admin.news.index') }}">
                          <div class="d-flex align-items-end gap-3 flex-wrap" style="gap:5px">

                                <div class="mb-2">
                                    <label><strong>From Date</strong></label>
                                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                </div>

                                <div class="mb-2">
                                    <label><strong>To Date</strong></label>
                                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                </div>

                                <div class="d-flex gap-2  mb-2" style="gap:3px">
                                    <button type="submit" class="btn btn-primary me-2 btn-fixed">Filter</button>
                                   <a href="{{ route('admin.news.index') }}" class="btn btn-secondary me-2 btn-fixed">Reset</a>
                                 
                                 </div>
                              
                            </div>
                        </form>

                <div class="table-responsive" >
                    <table class="table table-hover" id="datatablesSimple">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($news as $item)

                            <tr>
                                <td>{{ $item->id }}</td>

                                <td>{{ Str::limit(strip_tags($item->title), 40) }}</td>

                                <td>
                                    {{ Str::limit(strip_tags($item->description), 50) }}
                                </td>

                                <td>
                                    @if($item->image)
                                    <img src="{{ asset('uploads/news/'.$item->image) }}"
                                        width="80">
                                    @else
                                    N/A
                                    @endif
                                </td>

                                <td>
                                    @if($item->status == 1)
                                    <span class="badge badge-success">
                                        Active
                                    </span>
                                    @else
                                    <span class="badge badge-danger">
                                        Inactive
                                    </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $item->created_at->format('d-m-Y') }}
                                </td>

                                <td>
                                    <a href="{{ route('admin.news.edit',$item->id) }}"
                                        class="btn btn-primary btn-sm"
                                        title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>

                                    <a href="{{ route('admin.news.delete',$item->id) }}"
                                        class="btn btn-danger btn-sm"
                                        title="Delete"
                                        onclick="return confirm('Delete this news?')">
                                        <i class="mdi mdi-delete"></i>
                                    </a>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="7" class="text-center">
                                    No News Found
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection