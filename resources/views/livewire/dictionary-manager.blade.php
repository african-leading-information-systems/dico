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
        <div class="col-md-5 mb-1">
            <button type="button" class="btn btn-sm btn-primary" wire:click.prevent="openModal">
                <i class="ti-plus mr-1"></i>@lang('dicoLang::messages.buttons.add')
            </button>
        </div>
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm">
                <select name="" id="" class="form-control form-control-sm" wire:model="search_type">
                    <option value="">@lang('dicoLang::messages.allDictionaryType')</option>
                    @foreach($types as $t)
                        <option value="{{ $t->id }}">{{ $t->description }}</option>
                    @endforeach
                </select>
                <input wire:model="search_text" type="text" class="form-control form-control-sm ml-2"
                       name="table_search" placeholder="@lang('dicoLang::messages.buttons.search')"
                >
                <div class="input-group-append" wire:click.prevent="resetFilter">
                    <button type="submit" class="btn btn-danger">
                        <i class="ti-close mr-1"></i>@lang('dicoLang::messages.buttons.cancel')
                    </button>
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
                <th>@lang('dicoLang::messages.dictionaryType')</th>
                <th class="text-center">@lang('dicoLang::messages.dataColumns.code')</th>
                <th>@lang('dicoLang::messages.dataColumns.description')</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($dictionaries as $d)
            <tr>
                <td>{{ $d->type->description }}</td>
                <td class="text-center">{{ $d->code }}</td>
                <td>{{ $d->description }}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-primary btn-xs survolmt" wire:click.prevent="openModal({{ $d->id }})"
                            data-tooltip="@lang('dicoLang::messages.buttons.update')"
                    >
                        <i class="ti-pencil"></i>
                    </button>
                    <button type="button" onclick="window.event.preventDefault(); confirm('Etes vous sûr?') ? '' : window.event.stopImmediatePropagation()"
                            class="btn btn-danger btn-xs survolmt ml-1" wire:click.prevent="delete({{ $d->id }})"
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
    {{ $dictionaries->links() }}
    <!-- /.modal -->
    <div class="modal fade" id="modal-dico" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ $dictionary ? __('dicoLang::messages.updateDictionary') : __('dicoLang::messages.addDictionary') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" wire:submit.prevent="submit">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="code">
                                    @lang('dicoLang::messages.dataColumns.code') (<span class="text-danger">*</span>) :
                                </label>
                                <input type="text" id="code" wire:model="code" class="form-control" autocomplete="off"
                                       placeholder="@lang('dicoLang::messages.forms.codePlaceholder')"

                                >
                                @error('code') <span class="text-danger ml-3">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="">@lang('dicoLang::messages.dictionaryType') (<span class="text-danger">*</span>) :</label>
                                <select name="" id="" class="form-control" wire:model="type">
                                    <option value="">@lang('dicoLang::messages.forms.selecType')</option>
                                    @foreach($types as $t)
                                        <option value="{{ $t->id }}">{{ $t->description }}</option>
                                    @endforeach
                                </select>
                                @error('type') <span class="text-danger ml-3">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="">
                                    @lang('dicoLang::messages.dataColumns.description') (<span class="text-danger">*</span>) :
                                </label>
                                <x-dico-description-field />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
                            <i class="ti-close mr-1"></i>@lang('dicoLang::messages.buttons.close')
                        </button>
                        <button type="submit" class="btn btn-sm btn-{{ $dictionary ? 'primary': 'success' }}">
                            <i class="mr-1 ti-{{ $dictionary ? 'pencil': 'check' }}"></i>
                            {{ $dictionary ? __('dicoLang::messages.buttons.update') : __('dicoLang::messages.buttons.save') }}
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
            $('#modal-dico').modal()
        })
    </script>
@endpush

