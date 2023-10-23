<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="students"></x-navbars.sidebar>
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
                                <h6 class="text-white text-capitalize ps-3">Add Students</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2 m-2">
                            <div class="px-0 pb-2 m-2">
                                <form method='PUT' action='{{ route('students.update', ['student' => $student]) }}'
                                    id="studentEditForm">
                                    @csrf
                                    <div class="row">

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Email address</label>
                                            <input type="email" name="email"
                                                class="form-control border border-2 p-2" value='{{ $student->email }}'>
                                            <small
                                                class="text-danger error error_email">{{ $errors->first('email') }}</small>

                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name"
                                                class="form-control border border-2 p-2" value='{{ $student->name }}'>
                                            <small
                                                class="text-danger error error_name">{{ $errors->first('name') }}</small>

                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Phone</label>
                                            <input type="tel" name="tp"
                                                class="form-control border border-2 p-2"
                                                value='{{ $student->Student->tp }}'>
                                            <small class="text-danger error error_tp">{{ $errors->first('tp') }}</small>

                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Gender</label>
                                            <div class="form-group">
                                                <select class="form-control  border border-2 p-2" id="exampleGender"
                                                    value='{{ $student->Student->gender }}' name="gender">
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="non-binary">Non-Binary</option>
                                                </select>
                                            </div>

                                            <small
                                                class="text-danger error error_gender">{{ $errors->first('gender') }}</small>

                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label for="floatingTextarea2">Address</label>
                                            <textarea class="form-control border border-2 p-2" placeholder=" Write Here....." id="floatingTextarea2" name="address"
                                                rows="4" cols="50">{{ $student->Student->address }}</textarea>
                                            <small
                                                class="text-danger error error_address">{{ $errors->first('address') }}</small>

                                        </div>
                                    </div>
                                    <button type="submit" class="btn bg-gradient-dark">Submit</button>
                                </form>
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

            $("#studentEditForm").on('submit', function(e) {
                e.preventDefault();
                $('.error').text('');
                $('.form-group').removeClass('border--red');

                var action = $(this).attr('action');
                var formData = $(this).serialize();
                var method = $(this).attr('method');

                submitForm(action, method, formData);
                // Assuming you have a form ID "studentCreateForm"
                $('#studentCreateForm')[0].reset();

            });


            var table = $('#studentsDataTable').DataTable({
                'lengthMenu': [15, 30, 50, 100],
                'pageLength': 15,
                'ajax': {
                    'url': "{{ route('students.getData') }}",
                    // 'data': function(d) {
                    //     d.date_range = $("#date_range_value").val();
                    //     d.receptionist = $("#receptionists").val();
                    //     d.search_on = $('input[name="filter_on"]:checked').val();
                    // }
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
                        order

                    },
                    {
                        data: 'tp',
                        name: 'tp',
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

                ],
            });

        });
    </script>

</x-layout>
