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
                                <h6 class="text-white text-capitalize ps-3">Add Lectures</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2 m-2">
                            <div class="px-0 pb-2 m-2">
                                <form method='POST' action='{{ route('lectures.store') }}' id="lectureCreateForm">
                                    @csrf
                                    <div class="row">

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Tutor</label>
                                            <select class="form-control border border-2 p-2" name="tutor_id">
                                                @foreach ($tutors as $tutor )
                                                    <option value="{{$tutor->id}}">{{$tutor->User->name}}</option>
                                                @endforeach
                                            </select>
                                            <small
                                                class="text-danger error error_tutor_id">{{ $errors->first('tutor_id') }}</small>

                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Course</label>
                                            <select class="form-control border border-2 p-2" name="course_id">
                                                @foreach ($courses as $course )
                                                    <option value="{{$course->id}}">{{$course->course_name}}</option>
                                                @endforeach
                                            </select>
                                            <small
                                                class="text-danger error error_course_id">{{ $errors->first('course_id') }}</small>

                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Class Room</label>
                                            <select class="form-control border border-2 p-2" name="classroom_id">
                                                @foreach ($classRooms as $classRoom )
                                                    <option value="{{$classRoom->id}}">{{$classRoom->name}}</option>
                                                @endforeach
                                            </select>
                                            <small
                                                class="text-danger error error_classroom_id">{{ $errors->first('classroom_id') }}</small>

                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Time Slots</label>
                                            <div class="form-group">
                                                <select class="form-control  border border-2 p-2" id="exampleGender"
                                                    name="time_slot">
                                                    <option value="1">2PM - 4PM</option>
                                                    <option value="2">4PM - 6PM</option>
                                                    <option value="3">6PM - 8PM</option>
                                                </select>
                                            </div>

                                            <small
                                                class="text-danger error error_time_slot">{{ $errors->first('time_slot') }}</small>

                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Date</label>
                                            <input class="form-control border border-2 p-2" name="date" type="date">
                                            {{-- <select >
                                                @foreach ($tutors as $tutor )
                                                    <option value="{{$tutor->id}}">{{$tutor->User->name}}</option>
                                                @endforeach
                                            </select> --}}
                                            <small
                                                class="text-danger error error_date">{{ $errors->first('date') }}</small>

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

            $("#lectureCreateForm").on('submit', function(e) {
                e.preventDefault();
                $('.error').text('');
                $('.form-group').removeClass('border--red');

                var action = $(this).attr('action');
                var formData = $(this).serialize();
                var method = $(this).attr('method');

                submitForm(action, method, formData);
                $('#lectureCreateForm')[0].reset();

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
