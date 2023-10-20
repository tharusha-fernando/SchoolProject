<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="lectures"></x-navbars.sidebar>
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
                                <h6 class="text-white text-capitalize ps-3">Lectures table</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2 m-2 border rounded">
                            <div class=" me-3 my-3 text-end">
                                <a class="btn bg-gradient-dark mb-0" href="{{ route('lectures.create') }}"><i
                                        class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New
                                    Lecture</a>
                            </div>
                            <div class="table-responsive  m-2 p-2">
                                <table id="lecturesDataTable" class="table align-items-center" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>Course</th>
                                            <th>ClassRoom</th>
                                            <th>Tutor</th>
                                            <th>Date</th>
                                            <th>Start</th>
                                            <th>End</th>
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
                var lectureId = $(this).data('id');
                var url =
                    '{{ route('lectures.destroy', ['lecture' => '__lectureId']) }}'
                    .replace('__lectureId', lectureId);

                var lectureId = $(this).data('id');
                var url =
                    '{{ route('lectures.destroy', ['lecture' => '__lectureId']) }}'
                    .replace('__lectureId', lectureId);

                var confirmDelete = confirm("Are you sure you want to delete?");

                if (confirmDelete) {

                    deleteData(url, table, lectureId);
                }


            });

            var table = $('#lecturesDataTable').DataTable({
                'lengthMenu': [15, 30, 50, 100],
                'pageLength': 15,
                'ajax': {
                    'url': "{{ route('lectures.getData') }}",

                },
                'processing': true,
                'serverSide': true,
                dom: 'lBfrtip',

                columns: [{
                        data: 'course',
                        name: 'course',
                        'className': 'text-start',
                        orderable: false,

                    },
                    {
                        data: 'class_room',
                        name: 'class_room',
                        'className': 'text-start',
                        orderable: false,


                    },
                    // {
                    //     data: 'gender',
                    //     name: 'gender',
                    //     'className': 'text-start',

                    // },
                    {
                        data: 'tutor',
                        name: 'tutor',
                        'className': 'text-start',
                        orderable: false,


                    },
                    {
                        data: 'date',
                        name: 'date',
                        'className': 'text-start',

                    },
                    {
                        data: 'start_time',
                        name: 'start_time',
                        'className': 'text-start',

                    },
                    {
                        data: 'end_time',
                        name: 'end_time',
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
                'columnDefs': [{
                    "targets": 3,
                    "width": "60px",
                }, ],
            });

        });
    </script>

</x-layout>
