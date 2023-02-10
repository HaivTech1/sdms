<x-app-layout>
    @section('title', application('name')." | Class Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Upload</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Signatures</li>
            </ol>
        </div>
    </x-slot>

    <form id="upload">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="row" style="display: flex; justify-content: center; align-items: center">
                    <div style="">
                        <canvas style="border-radius: 5px; margin: 5px; width: 150px; height: 150px" id="img-show" class="img-thumbnail img-response"></canvas>
                    </div>
                    <div style="margin-right: 10px; padding: 5px">
                            <x-form.label for="signature" value="{{ __('Signature') }}" />
                            <x-form.input id="signature" class="block w-full mt-1" type="file" name="signature"/>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="row" style="display: flex; justify-content: center; align-items: center">
                    <div style="">
                        <canvas style="border-radius: 5px; margin: 5px; width: 150px; height: 150px" id="img-show2" class="img-thumbnail2 img-response"></canvas>
                    </div>
                    <div style="margin-right: 10px; padding: 5px">
                            <x-form.label for="stamp" value="{{ __('Stamp') }}" />
                            <x-form.input id="stamp" class="block w-full mt-1" type="file" name="stamp"/>
                    </div>
                    
                </div>
            </div>

            <div style="display: flex; justify-content: center; align-items: center; margin-top: 5px">
                <button id="submit" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Submit</button>
            </div>
        </div>
    </form>

    @section('scripts')
        <script>
           
            var input1 = document.getElementById('signature');
            var input2 = document.getElementById('stamp');

             // see Example 4
            input1.onchange = function () {
                var file = input1.files[0];
                drawOnCanvas(file);   // see Example 6
                // displayAsImage(file); // see Example 7
            };

             input2.onchange = function () {
                var file = input2.files[0];
                drawOnCanvas2(file);   // see Example 6
                // displayAsImage(file); // see Example 7
            };

            function drawOnCanvas(file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var dataURL = e.target.result,
                        c = document.querySelector('#img-show'), // see Example 4
                        ctx = c.getContext('2d'),
                        img = new Image();

                    $('#img-show-container').show()

                    img.onload = function() {
                    c.width = img.width;
                    c.height = img.height;
                    ctx.drawImage(img, 0, 0);
                    };
                    img.src = dataURL;
                };
                reader.readAsDataURL(file);
            }

            function drawOnCanvas2(file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var dataURL = e.target.result,
                        c = document.querySelector('#img-show2'), // see Example 4
                        ctx = c.getContext('2d'),
                        img = new Image();

                    $('#img-show-container2').show()

                    img.onload = function() {
                    c.width = img.width;
                    c.height = img.height;
                    ctx.drawImage(img, 0, 0);
                    };
                    img.src = dataURL;
                };
                reader.readAsDataURL(file);
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            $(document).on('submit', '#upload', function (e) {
                e.preventDefault();
                let formData = new FormData($('#upload')[0]);
                toggleAble('#submit', true, 'Submitting...');
                var url = "{{ route('upload.uploadSignature') }}";

                $.ajax({
                    method: "POST",
                    url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done((res) => {
                    if(res.status === 'success') {
                        toggleAble('#submit', false);
                        toastr.success(res.message, 'Success!');
                        $('#img-show-container').hide();
                        $('#img-show-container2').hide();
                    }else{
                        toggleAble('#submit', false);
                        toastr.error(res.message, 'Success!');
                    }
                    resetForm('#upload')
                }).fail((err) => {
                    console.log(err);
                    toggleAble('#submit', false);
                    let allErrors = Object.values(err.responseJSON.errors).map(el => (
                            el = `<li>${el}</li>`
                        )).reduce((next, prev) => ( next = prev + next ));

                    const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul>${allErrors}</ul>
                                        </div>
                                        `;

                    $('.modalErrorr').html(setErrors);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });
        </script>
    @endsection
</x-app-layout>