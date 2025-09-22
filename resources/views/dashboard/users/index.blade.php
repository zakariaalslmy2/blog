@extends('dashboard.layout.layout')

@section('body')
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ __('words.dashboard') }}</li>
        <li class="breadcrumb-item"><a href="#">{{ __('words.dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">داشبرد</li>
    </ol>


    <div class="container-fluid">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Striped Table
                </div>
                <div class="card-block">
                    <table class="table table-striped" id="table_id">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Date registered</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>





    {{-- delete --}}
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ Route('dashboard.users.delete') }}" method="POST">
                <div class="modal-content">

                    <div class="modal-body">
                        @csrf

                        <div class="form-group">
                            <p>{{ __('words.sure delete') }}</p>
                            @csrf
                            <input type="hidden" name="id" id="id">
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">{{ __('words.close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('words.delete') }} </button>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- delete --}}
@endsection
@push('javascripts')
<script type="text/javascript">
    $(function() {
        var table = $('#table_id').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ Route('dashboard.users.all') }}",
            columns: [
                // <th>Username</th> -> maps to 'name' key from server
                { data: 'name', name: 'name' },

                // <th>Date registered</th> -> This column is missing from the controller.
                // For now, let's display email here until you add the registration date to the controller.
                // Or you can remove the <th> from HTML. We will display 'email' for now.
                { data: 'email', name: 'email' },

                // <th>Role</th> -> maps to the 'role' column you added in the controller
                { data: 'role', name: 'role', orderable: false, searchable: false },

                // <th>Status</th> -> maps to the 'status_text' column you added for clarity
                { data: 'status_text', name: 'status' }, // Using 'status' as name for server-side searching/sorting

                // <th>Action</th> -> maps to 'action' column from server
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });

    $('#table_id tbody').on('click', '#deleteBtn', function(argument) {
        var id = $(this).attr("data-id");
        $('#deletemodal #id').val(id);
    });
</script>
@endpush
