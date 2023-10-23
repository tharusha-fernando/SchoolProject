<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="courses"></x-navbars.sidebar>
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
                                <h6 class="text-white text-capitalize ps-3">Add Course</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2 m-2">
                            <div class="px-0 pb-2 m-2">
                                <form method='POST' action='{{ route('courses.store') }}' id="studentCreateForm">
                                    @csrf
                                    <div class="row">

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Code</label>
                                            <input type="text" name="course_code"
                                                class="form-control border border-2 p-2" value=''>
                                            <small
                                                class="text-danger error error_course_code">{{ $errors->first('course_code') }}</small>

                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Course Name</label>
                                            <input type="text" name="course_name"
                                                class="form-control border border-2 p-2" value=''>
                                            <small
                                                class="text-danger error error_course_name">{{ $errors->first('course_name') }}</small>

                                        </div>

                                        {{-- <div class="mb-3 col-md-6">
                                            <label class="form-label">Phone</label>
                                            <input type="number" name="tp"
                                                class="form-control border border-2 p-2" value=''>
                                            <small class="text-danger error error_tp">{{ $errors->first('tp') }}</small>

                                        </div> --}}

                                        {{-- <div class="mb-3 col-md-6">
                                            <label class="form-label">Gender</label>
                                            <div class="form-group">
                                                <select class="form-control  border border-2 p-2" id="exampleGender"
                                                    name="gender">
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="non-binary">Non-Binary</option>
                                                </select>
                                            </div>

                                            <small
                                                class="text-danger error error_gender">{{ $errors->first('gender') }}</small>

                                        </div> --}}
                                        <div class="mb-3 col-md-12">
                                            <label for="floatingTextarea2">Description</label>
                                            <textarea class="form-control border border-2 p-2" placeholder=" Write Here....." id="floatingTextarea2"
                                                name="description" rows="4" cols="50"></textarea>
                                            <small
                                                class="text-danger error error_description">{{ $errors->first('description') }}</small>

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

            $("#studentCreateForm").on('submit', function(e) {
                e.preventDefault();
                $('.error').text('');
                $('.form-group').removeClass('border--red');

                var action = $(this).attr('action');
                var formData = $(this).serialize();
                var method = $(this).attr('method');

                submitForm(action, method, formData);
                $('#studentCreateForm')[0].reset();

            });


            var table = $('#studentsDataTable').DataTable({
                'lengthMenu': [15, 30, 50, 100],
                'pageLength': 15,
                'ajax': {
                    'url': "{{ route('students.getData') }}",

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
