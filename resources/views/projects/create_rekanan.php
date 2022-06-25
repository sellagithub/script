@php
    $deleteProjectCategoryPermission = user()->permission('delete_project_category');
@endphp

<div class="modal-header">
    <h5 class="modal-title" id="modelHeading">Pilih Rekanan</h5> 
    <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <x-table class="table-bordered" headType="thead-light">
        <x-slot name="thead">
            <th>#</th>
            <th>Nama Rekanan</th>
            <th class="text-right">Aksi</th>
        </x-slot>

        @forelse($semuaRekanan as $key=>$pilihrekanan)
            <tr id="cat-{{ $pilihrekanan->id }}">
                <td>{{ $key + 1 }}</td>
                <td data-row-id="{{ $pilihrekanan->id }}" contenteditable="true">{{ ucwords($pilihrekanan->rekanan_name) }}</td>
                <td class="text-right">
                    @if ($deleteProjectCategoryPermission == 'all' || ($deleteProjectCategoryPermission == 'added' && $pilihrekanan->added_by == user()->id))
                        <x-forms.button-secondary data-cat-id="{{ $pilihrekanan->id }}" icon="trash" class="delete-pilihrekanan">
                            @lang('app.delete')
                        </x-forms.button-secondary>
                    @endif
            </tr>
        @empty
            <tr>
                <td colspan="3">@lang('messages.noRecordFound')</td>
            </tr>
        @endforelse
    </x-table>

    <x-form id="createRekanan">
        <div class="row border-top-grey ">
            <div class="col-sm-12">
                <x-forms.text fieldId="rekanan_name" :fieldLabel="__('Nama Rekanan')"
                    fieldName="rekanan_name" fieldRequired="true" :fieldPlaceholder="__('Rekanan')">
                </x-forms.text>
            </div>

        </div>
    </x-form>
</div>
<div class="modal-footer">
    <x-forms.button-cancel data-dismiss="modal" class="border-0 mr-3">tutup</x-forms.button-cancel>
    <x-forms.button-primary id="save-pilihrekanan" icon="check">simpan</x-forms.button-primary>
</div>

<script>
    $('.delete-pilihrekanan').click(function() {

        var id = $(this).data('cat-id');
        var url = "{{ route('Rekanan.destroy', ':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        Swal.fire({
            title: "@lang('messages.sweetAlertTitle')",
            text: "@lang('messages.recoverRecord')",
            icon: 'warning',
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: "@lang('messages.confirmDelete')",
            cancelButtonText: "@lang('app.cancel')",
            customClass: {
                confirmButton: 'btn btn-primary mr-3',
                cancelButton: 'btn btn-secondary'
            },
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.easyAjax({
                    type: 'POST',
                    url: url,
                    data: {
                        '_token': token,
                        '_method': 'DELETE'
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#cat-' + id).fadeOut();
                            $('#pilihrekanan_id').html(response.data);
                            $('#pilihrekanan_id').selectpicker('refresh');
                        }
                    }
                });
            }
        });

    });

    $('#save-pilihrekanan').click(function() {
        var url = "{{ route('Rekanan.store') }}";
        $.easyAjax({
            url: url,
            container: '#createRekanan',
            type: "POST",
            data: $('#createRekanan').serialize(),
            success: function(response) {
                if (response.status == 'success') {
                    $('#pilihrekanan_id').html(response.data);
                    $('#pilihrekanan_id').selectpicker('refresh');
                    $(MODAL_LG).modal('hide');
                }
            }
        })
    });

    $('[contenteditable=true]').focus(function() {
        $(this).data("initialText", $(this).html());
        let rowId = $(this).data('row-id');
    }).blur(function() {
        if ($(this).data("initialText") !== $(this).html()) {
            let id = $(this).data('row-id');
            let value = $(this).html();

            var url = "{{ route('Rekanan.update', ':id') }}";
            url = url.replace(':id', id);

            var token = "{{ csrf_token() }}";

            $.easyAjax({
                url: url,
                container: '#row-' + id,
                type: "POST",
                data: {
                    'rekanan_name': value,
                    '_token': token,
                    '_method': 'PUT'
                },
                blockUI: true,
                success: function(response) {
                    if (response.status == 'success') {
                        $('#pilihrekanan_id').html(response.data);
                        $('#pilihrekanan_id').selectpicker('refresh');
                    }
                }
            })
        }
    });

</script>
