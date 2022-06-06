@php
    $deleteProjectCategoryPermission = user()->permission('delete_project_category');
@endphp

<div class="modal-header">
    <h5 class="modal-title" id="modelHeading">@lang('modules.projects.Project_type')</h5>
    <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <x-table class="table-bordered" headType="thead-light">
        <x-slot name="thead">
            <th>#</th>
            <th>@lang('modules.Project_type.project_type_name')</th>
            <th class="text-right">@lang('app.action')</th>
        </x-slot>

        @forelse($tipeprojek as $key=>$projek)
            <tr id="cat-{{ $projek->id }}">
                <td>{{ $key + 1 }}</td>
                <td data-row-id="{{ $projek->id }}" contenteditable="true">{{ ucwords($projek->project_type_name) }}</td>
                <td class="text-right">
                    @if ($deleteProjectCategoryPermission == 'all' || ($deleteProjectCategoryPermission == 'added' && $projek->added_by == user()->id))
                        <x-forms.button-secondary data-cat-id="{{ $projek->id }}" icon="trash" class="delete-projek">
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

    <x-form id="createProject_type">
        <div class="row border-top-grey ">
            <div class="col-sm-12">
                <x-forms.text fieldId="project_type_name" :fieldLabel="__('modules.Project_type.project_type_name')"
                    fieldName="project_type_name" fieldRequired="true" :fieldPlaceholder="__('placeholders.category')">
                </x-forms.text>
            </div>

        </div>
    </x-form>
</div>
<div class="modal-footer">
    <x-forms.button-cancel data-dismiss="modal" class="border-0 mr-3">@lang('app.close')</x-forms.button-cancel>
    <x-forms.button-primary id="save-projek" icon="check">@lang('app.save')</x-forms.button-primary>
</div>

<script>
    $('.delete-projek').click(function() {

        var id = $(this).data('cat-id');
        var url = "{{ route('Project_type.destroy', ':id') }}";
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
                            $('#project_type_id').html(response.data);
                            $('#project_type_id').selectpicker('refresh');
                        }
                    }
                });
            }
        });

    });

    $('#save-projek').click(function() {
        var url = "{{ route('Project_type.store') }}";
        $.easyAjax({
            url: url,
            container: '#createProject_type',
            type: "POST",
            data: $('#createProject_type').serialize(),
            success: function(response) {
                if (response.status == 'success') {
                    $('#project_type_id').html(response.data);
                    $('#project_type_id').selectpicker('refresh');
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

            var url = "{{ route('Project_type.update', ':id') }}";
            url = url.replace(':id', id);

            var token = "{{ csrf_token() }}";

            $.easyAjax({
                url: url,
                container: '#row-' + id,
                type: "POST",
                data: {
                    'project_type_name': value,
                    '_token': token,
                    '_method': 'PUT'
                },
                blockUI: true,
                success: function(response) {
                    if (response.status == 'success') {
                        $('#project_type_id').html(response.data);
                        $('#project_type_id').selectpicker('refresh');
                    }
                }
            })
        }
    });

</script>
