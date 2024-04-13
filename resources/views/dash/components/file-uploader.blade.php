<input class="form-control" type="file" name="img" id="fileInput" accept="image/jpg,image/jpeg" />
@push('styles')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

<script type="text/javascript">
    FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

    const remove = (source, load, errorCall) => {

        const parts = source.split('/');
        const id = parts[ parts.length - 2 ];

        const url = @json(url('dashboard/media/'))+`/${id}`;

        $.ajax({
            type: "DELETE",
            url,
            headers: {
                'X-CSRF-TOKEN': `{{ csrf_token() }}`
            },
            success: function (response) {
                load();
                Toast.fire({
                    icon: "success",
                    title: response.message
                    });
            },error: function (xhr, status, error) {
                Toast.fire({
                icon: "error",
                title: xhr.responseJSON.errors
                });
                errorCall(xhr.responseJSON.errors);
            }
        });
    }

    const pond = FilePond.create(document.getElementById('fileInput'),
        {
            credits: false,
            storeAsFile: true,
            acceptedFileTypes: ['image/*'],
            maxFileSize: '5MB',
            server: {
                remove: remove,
                load: '/'
            }
        }
    );


    let files = @json($files ?? []);

        files = Array.isArray(files) ? files : [files];

        files = files.map(file => {
        return {
        source: new URL(file).pathname,
        options: {
        type: 'local',
        },
        }
        });

    pond.addFiles(files);

</script>
@endpush