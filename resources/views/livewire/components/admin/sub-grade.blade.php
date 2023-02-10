<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    <x-search />
                                </div>

                                <div class="col-lg-8">
                                    <div class="row">
                                        
                                        @if($selectedRows)
                                        <div class="col-6">
                                            <div class="btn-group btn-group-example mb-3" role="group">
                                                <button wire:click.prevent="deleteAll" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-block"></i>
                                                    Delete All
                                                </button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </diV>
                            </div>
                        </div>
                    </div>

                    <div class='row'>

                        <div class='col-sm-8'>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-check">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20px;" class="align-middle">
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                                        wire:model="selectPageRows">
                                                    <label class="form-check-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th class="align-middle">#</th>
                                            <th class="align-middle"> Title</th>
                                            <th class="align-middle"> Status</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subgrades as $key => $subgrade)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="{{ $subgrade->id() }}"
                                                        type="checkbox" id="{{ $subgrade->id() }}" wire:model="selectedRows">
                                                    <label class="form-check-label" for="{{ $subgrade->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript: void(0);"
                                                    class="text-body fw-bold">{{ $key+1 }}</a>
                                            </td>
                                            <td>
                                                <span>{{ $subgrade->grade->title() }}</span>
                                                <span><livewire:components.edit-title :model='$subgrade' field='title' :key='$subgrade->id()'/></span>
                                            </td>
                                            <td>
                                                <livewire:components.toggle-button :model='$subgrade' field='status' :key='$subgrade->id()'/>
                                            </td>
                                            <td>
                                                <button type="button"  class="btn btn-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="right" title="Click to show class details" wire:click="subgradeDetails({{ $subgrade->id() }})" class="dropdown-item">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $subgrades->links('pagination::custom-pagination')}}
                        </div>
                        <div class='col-sm-4'>
                            <form wire:submit.prevent="createSubGrade">
                                <div class="col-sm-12">
                                    <x-form.label for="title" value="{{ __('Sub Class Name') }}" />
                                    <input class="form-control me-auto" wire:model.defer="title" placeholder="Add your class here..."
                                        aria-label="Add your class here...">
                                    <x-form.error for="title" />
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <x-form.label for="grade_id" value="{{ __('Class') }}" />
                                    <select class="form-control" wire:model.defer="grade_id">
                                        <option>Select</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{ $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="grade_id" />
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-secondary">Add</button>
                                    <div class="vr"></div>
                                    <button wire:click="resetState" type="button" class="btn btn-outline-danger">Reset</button>
                                </div>
                            </form>

                            @if ($subgrade_details)
                                <div id="details" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-fullscreen">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalFullscreenLabel">Class Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col sm-12">
                                                        <h5>{{ $subgrade_details->title() }}</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-nowrap mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col"></th>
                                                                <th scope="col" class="text-center">
                                                                xs<br>
                                                                <span class="fw-normal">&lt;576px</span>
                                                                </th>
                                                                <th scope="col" class="text-center">
                                                                sm<br>
                                                                <span class="fw-normal">≥576px</span>
                                                                </th>
                                                                <th scope="col" class="text-center">
                                                                md<br>
                                                                <span class="fw-normal">≥768px</span>
                                                                </th>
                                                                <th scope="col" class="text-center">
                                                                lg<br>
                                                                <span class="fw-normal">≥992px</span>
                                                                </th>
                                                                <th scope="col" class="text-center">
                                                                xl<br>
                                                                <span class="fw-normal">≥1200px</span>
                                                                </th>
                                                                <th scope="col" class="text-center">
                                                                xxl<br>
                                                                <span class="fw-normal">≥1400px</span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Grid behavior</th>
                                                            <td>Horizontal at all times</td>
                                                            <td colspan="5">Collapsed to start, horizontal above breakpoints</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Max container width</th>
                                                            <td>None (auto)</td>
                                                            <td>540px</td>
                                                            <td>720px</td>
                                                            <td>960px</td>
                                                            <td>1140px</td>
                                                            <td>1320px</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Class prefix</th>
                                                            <td><code>.col-</code></td>
                                                            <td><code>.col-sm-</code></td>
                                                            <td><code>.col-md-</code></td>
                                                            <td><code>.col-lg-</code></td>
                                                            <td><code>.col-xl-</code></td>
                                                            <td><code>.col-xxl-</code></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row"># of columns</th>
                                                            <td colspan="6">12</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Gutter width</th>
                                                            <td colspan="6">24px (12px on each side of a column)</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Custom gutters</th>
                                                            <td colspan="6">Yes</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Nestable</th>
                                                            <td colspan="6">Yes</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Offsets</th>
                                                            <td colspan="6">Yes</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Column ordering</th>
                                                            <td colspan="6">Yes</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


