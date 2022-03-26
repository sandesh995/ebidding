@props(['element' => '.editor'])

@push('js')
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
<script>
    ClassicEditor
			.create( document.querySelector( '{{ $element }}' ), {
				toolbar: {
					items: [
						'heading',
						'|',
						'bold',
						'italic',
						'|',
						'link',
						'bulletedList',
						'numberedList',
						'|',
						'horizontalLine',
						'code',
						'codeBlock',
						'blockQuote',
						'|',
						'undo',
						'redo',
						'removeFormat'
					]
				},
				language: 'en',
				licenseKey: '',
			} )
			.then( editor => {
				window.editor = editor;
			} )
			.catch( error => {
				console.error( 'Oops, something went wrong!' );
				console.error( error );
			} );
</script>
@endpush