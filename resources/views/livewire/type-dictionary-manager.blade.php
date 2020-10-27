<div>
    <div class="row mb-2">
        <div class="col-md-1 mb-1">
            <div class="input-group input-group-sm">
                <select name="" id="" class="form-control form-control-sm" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        <div class="col-md-7 mb-1">
            <button type="button" class="btn btn-sm btn-primary" wire:click.prevent="openModal">
                <i class="ti-plus mr-1"></i>@lang('dicoLang::messages.buttons.add')
            </button>
        </div>
        <div class="col-md-4 mb-1">
            <div class="input-group input-group-sm">
                <input wire:model="search_text" type="text" class="form-control form-control-sm"
                       name="table_search" placeholder="@lang('dicoLang::messages.buttons.search')"
                >
                <div class="input-group-append" wire:click.prevent="resetFilter">
                    <button type="submit" class="btn btn-danger">
                        <i class="ti-close mr-1"></i>@lang('dicoLang::messages.buttons.cancel')</button>
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('message-success'))
        <div class="alert alert-success">
            {{ session('message-success') }}
        </div>
    @endif
    @if (session()->has('message-error'))
        <div class="alert alert-danger">
            {{ session('message-error') }}
        </div>
    @endif
    <table class="table table-responsible table-hover fixed text-center">
        <thead>
            <tr>
                <th class="text-center">@lang('dicoLang::messages.dataColumns.code')</th>
                <th>@lang('dicoLang::messages.dataColumns.description')</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($types as $type)
                <tr>
                    <td class="text-center">{{ $type->code }}</td>
                    <td>{{ $type->description }}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-primary btn-xs survolmt" wire:click.prevent="openModal({{ $type->id }})"
                                data-tooltip="@lang('dicoLang::messages.buttons.update')"
                        >
                            <i class="ti-pencil"></i>
                        </button>
                        <button onclick="window.event.preventDefault(); confirm('Etes vous sûr?') ? '' : window.event.stopImmediatePropagation()"
                                type="button" class="btn btn-danger btn-xs survolmt ml-1" wire:click.prevent="delete({{ $type->id }})"
                                data-tooltip="@lang('dicoLang::messages.buttons.delete')"
                        >
                            <i class="icon-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    {{ $types->links() }}
    <!-- /.modal -->
    <div class="modal fade" id="modal-type-dico" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ $type ? __('dicoLang::messages.updateDictionaryType') : __('dicoLang::messages.addDictionaryType') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" wire:submit.prevent="submit">
                    <div class="modal-body">
                        <div class="col-md-12 form-group">
                            <label for="">
                                @lang('dicoLang::messages.dataColumns.code') (<span class="text-danger">*</span>) :
                            </label>
                            <input type="text" wire:model="code" class="form-control" autocomplete="off"
                                   placeholder="@lang('dicoLang::messages.forms.codePlaceholder')"
                            >
                            @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">
                                @lang('dicoLang::messages.dataColumns.description') (<span class="text-danger">*</span>) :
                            </label>
                            <x-dico-description-field />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
                            <i class="ti-close mr-1"></i>@lang('dicoLang::messages.buttons.close')
                        </button>
                        <button type="submit" class="btn btn-sm btn-{{ $type ? 'primary' : 'success' }}">
                            <i class="mr-1 ti-{{ $type ? 'pencil' : 'check' }}"></i>
                            {{ $type ? __('dicoLang::messages.buttons.update') : __('dicoLang::messages.buttons.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
@push('dic-script')
    <script>
        Livewire.on('openModal', () => {
            console.log('okey')
            $('#modal-type-dico').modal()
        })
    </script>
@endpush
