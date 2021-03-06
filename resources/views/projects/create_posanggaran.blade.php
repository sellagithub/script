@php
    $deleteProjectCategoryPermission = user()->permission('delete_project_category');
@endphp

<div class="modal-header">
    <h5 class="modal-title" id="modelHeading">Pos Anggaran</h5> 
    <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <x-table class="table-bordered" headType="thead-light">
        <x-slot name="thead">
            <th>#</th>
            <th>Nama Pos Anggaran</th>
            <th class="text-right">Aksi</th>
        </x-slot>

        @forelse($semuaPosAnggaran as $key=>$pos_anggaran)
            <tr id="cat-{{ $pos_anggaran->id }}">
                <td>{{ $key + 1 }}</td>
                <td data-row-id="{{ $pos_anggaran->id }}" contenteditable="true">{{ ucwords($pos_anggaran->pos_anggaran_name) }}</td>
                <td class="text-right">
                    @if ($deleteProjectCategoryPermission == 'all' || ($deleteProjectCategoryPermission == 'added' && $pos_anggaran->added_by == user()->id))
                        <x-forms.button-secondary data-cat-id="{{ $pos_anggaran->id }}" icon="trash" class="delete-pos_anggaran">
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

    <x-form id="createPos_Anggaran">
        <div class="row border-top-grey ">
            <div class="col-sm-12">
                <x-forms.text fieldId="pos_anggaran_name" :fieldLabel="__('Pos Anggaran')"
                    fieldName="pos_anggaran_name" fieldRequired="true" :fieldPlaceholder="__('Pos Anggaran')">
                </x-forms.text>
            </div>

        </div>
    </x-form>
</div>
<div class="modal-footer">
    <x-forms.button-cancel data-dismiss="modal" class="border-0 mr-3">tutup</x-forms.button-cancel>
    <x-forms.button-primary id="save-pos_anggaran" icon="check">simpan</x-forms.button-primary>
</div>

<script>
    $('.delete-pos_anggaran').click(function() {

        var id = $(this).data('cat-id');
        var url = "{{ route('Pos_Anggaran.destroy', ':id') }}";
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
                            $('#pos_anggaran_id').html(response.data);
                            $('#pos_anggaran_id').selectpicker('refresh');
                        }
                    }
                });
            }
        });

    });

    $('#save-pos_anggaran').click(function() {
        var url = "{{ route('Pos_Anggaran.store') }}";
        $.easyAjax({
            url: url,
            container: '#createPos_Anggaran',
            type: "POST",
            data: $('#createPos_Anggaran').serialize(),
            success: function(response) {
                if (response.status == 'success') {
                    $('#pos_anggaran_id').html(response.data);
                    $('#pos_anggaran_id').selectpicker('refresh');
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

            var url = "{{ route('Pos_Anggaran.update', ':id') }}";
            url = url.replace(':id', id);

            var token = "{{ csrf_token() }}";

            $.easyAjax({
                url: url,
                container: '#row-' + id,
                type: "POST",
                data: {
                    'pos_anggaran_name': value,
                    '_token': token,
                    '_method': 'PUT'
                },
                blockUI: true,
                success: function(response) {
                    if (response.status == 'success') {
                        $('#pos_anggaran_id').html(response.data);
                        $('#pos_anggaran_id').selectpicker('refresh');
                    }
                }
            })
        }
    });

</script>
