@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="table-1">
                            <thead>
                                <tr>
                                    <th>Log Name</th>
                                    <th>Description</th>
                                    <th>Causer</th>
                                    <th>Event</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_script')
    <script>
        var dataTable;
        $(function () {
            dataTable = $('#table-1').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '',
                columns: [
                    { data: 'log_name', name: 'log_name' },
                    { data: 'description', name: 'description' },
                    { data: 'causer.name', name: 'causer.name' },
                    { data: 'event', name: 'event' },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function (data, type, row) {
                            return moment(data).fromNow();
                        }
                    }
                ]
            });
        });
    </script>
@endpush
