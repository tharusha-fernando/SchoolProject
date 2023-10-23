<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="threads"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Tables"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Chat</h6>
                </div>
            </div>
            <div class="row" style="height: 400px; overflow-y: scroll;">
                @foreach ($thread->Message as $Message)
                    <div class="col-md-12 mb-3">
                        <div class="card {{ $Message->user_id == auth()->user()->id ? 'text-end' : 'text-start' }}">
                            <div class="card-header p-3 pt-2">
                                <div class="pt-1">
                                    <p class="text-xl mb-0 text-capitalize">{{ $Message->User->name }}</p>
                                    <h6 class="mb-0">{{ $Message->message }}</h6>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="row card m-4">

                <div class="px-0 pb-2 m-2">
                    <form method='POST' action='{{ route('messages.store') }}' id="messageCreateForm">
                        @csrf
                        <div class="row ">
                
                            <div class="mb-3 col-md-12">
                                <label for="floatingTextarea2">Message</label>
                                <textarea class="form-control border border-2 p-2" placeholder=" Say something about yourself" id="floatingTextarea2"
                                    name="message" rows="4" cols="50"></textarea>
                                {{-- <small
                                    class="text-danger error error_message">{{ $errors->first('message') }}</small> --}}

                                    <small class="text-danger">{{ $errors->first('message') }}</small> 
                            </div>
                        </div>
                        <input type="hidden" value="{{$thread->id}}" name="thread_id">
                        {{-- <input type="hidden" value="{{$thread->id}}" name="thread_id"> --}}

                        <button type="submit" class="btn bg-gradient-dark">Send</button>
                    </form>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins>
    </x-plugins>
    <script>
        $(document).ready(function() {

            $(document).on("click", ".removeBtn", function() {
                var courseId = $(this).data('id');
                var url =
                    '{{ route('my-courses.destroy', ['my_course' => '__courseId']) }}'
                    .replace('__courseId', courseId);

                var courseId = $(this).data('id');
                var url =
                    '{{ route('my-courses.destroy', ['my_course' => '__courseId']) }}'
                    .replace('__courseId', courseId);

                var confirmDelete = confirm("Are you sure you want to remove?");

                if (confirmDelete) {
                    deleteData(url, table, courseId);
                }


            });



            // $("#messageCreateForm").on('submit', function(e) {
            //     e.preventDefault();
            //     $('.error').text('');
            //     $('.form-group').removeClass('border--red');

            //     var action = $(this).attr('action');
            //     var formData = $(this).serialize();
            //     var method = $(this).attr('method');

            //     submitForm(action, method, formData);
            //     $('#messageCreateForm')[0].reset();

            // });





        });
    </script>

</x-layout>
