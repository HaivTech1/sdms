<div class="col-md-4">
    <div class="card mini-stats-wid">
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-grow-1">
                    <p class="text-muted fw-medium">{{ $title}}</p>
                    <h4 class="mb-0"> {{ trans('global.naira') }}  {{ number_format(intval($amount), 2) }}</h4>
                </div>

                <div class="flex-shrink-0 align-self-center">
                    <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                        <span class="avatar-title">
                            <i class="{{ $iconClass }} font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@props(['title', 'amount', 'iconClass'])