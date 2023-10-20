<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tutors"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Tables"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Tutors table</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2 m-2 border rounded">
                            <div class=" me-3 my-3 text-end">
                                <a class="btn bg-gradient-dark mb-0" href="{{ route('tutors.create') }}"><i
                                        class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New
                                    Tutor</a>
                            </div>
                            <div class="table-responsive  m-2 p-2">
                                <table id="tutorsDataTable" class="table align-items-center" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Gender</th>
                                            <th>Address</th>
                                            <th>Telephone</th>
                                            <th>Courses</th>

                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins>
    </x-plugins>
    <script>
        $(document).ready(function() {

            $(document).on("click", ".deleteBtn", function() {
                var tutorId = $(this).data('id');
                var url =
                    '{{ route('tutors.destroy', ['tutor' => '__tutorId']) }}'
                    .replace('__tutorId', tutorId);

                var studentId = $(this).data('id');
                var url =
                    '{{ route('tutors.destroy', ['tutor' => '__tutorId']) }}'
                    .replace('__tutorId', tutorId);

                var confirmDelete = confirm("Are you sure you want to delete?");

                if (confirmDelete) {

                    deleteData(url, table, tutorId);
                }


            });

            var table = $('#tutorsDataTable').DataTable({
                'lengthMenu': [15, 30, 50, 100],
                'pageLength': 15,
                'ajax': {
                    'url': "{{ route('tutors.getData') }}",

                },
                'processing': true,
                'serverSide': true,
                dom: 'lBfrtip',

                columns: [{
                        data: 'name',
                        name: 'name',
                        'className': 'text-start',

                    },
                    {
                        data: 'email',
                        name: 'email',
                        'className': 'text-start',

                    },
                    {
                        data: 'gender',
                        name: 'gender',
                        'className': 'text-start',

                    },
                    {
                        data: 'address',
                        name: 'address',
                        'className': 'text-start',

                    },
                    {
                        data: 'tp',
                        name: 'tp',
                        'className': 'text-start',

                    },
                    {
                        data: 'courses',
                        name: 'courses',
                        'className': 'text-start',

                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        'className': 'text-center',

                    },


                ],
                'order': [
                    [0, 'desc']
                ],
                'columnDefs': [

                    {
                        "targets": 3,
                        "width": "100px",
                    },
                ],
            });

        });
    </script>

</x-layout>
