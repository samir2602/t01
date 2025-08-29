<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tags') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-links href="tag/create">+ Tag</x-links>
                </div>
                <div class="p-6 text-gray-900">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tag Name</th>                            
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>        
    </div>
</x-app-layout>

<script type="text/javascript">
$(function () {   
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('tag.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'tag_name', name: 'tag_name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click','.delete',function(e){     
    var id = $(this).data('id');
    swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Confirm!'
    }).then(function(){
        $.ajax({
            url: '/tag/' + id, // Replace with your actual route
            type: 'DELETE',
            success: function(response) {                
                var table = $('.data-table').DataTable();
                table.clear().draw();
            },
            error: function(xhr) {              
                console.log(xhr.responseText);
            }
        });
    }).catch(function(reason){
        
    });
});
</script>
