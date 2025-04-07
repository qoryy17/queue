@extends('layout.body')
@section('title', $title)
@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                @foreach ($breadCumbs as $breadItem)
                                    <li class="breadcrumb-item" {{ $breadItem['page'] }}>
                                        <a href="{{ $breadItem['link'] }}">{{ $breadItem['title'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="card">
                <form action="{{ route('officers.store') }}" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                        <h4 class="card-title d-flex flex-row justify-content-between">
                            {{ $pageTitle }}
                            <a href="{{ route('officers.index') }}" class="fs-5 float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('POST')
                        @if (Crypt::decrypt($paramForm) === 'update')
                            <div class="form-group mb-3" hidden>
                                <label class="form-label" for="id">Officer ID</label>
                                <input type="text" class="form-control" id="id" name="id"
                                    value="{{ Crypt::encrypt($officer->id) }}" readonly>
                            </div>
                        @endif
                        <div class="form-group mb-3" hidden>
                            <label class="form-label" for="paramForm">Parameter</label>
                            <input type="text" class="form-control" id="paramForm" name="paramForm"
                                value="{{ $paramForm }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="nip">NIP </label>
                            <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP..."
                                value="{{ $officer ? $officer->nip : old('nip') }}">
                            @error('nip')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required
                                placeholder="Name..." value="{{ $officer ? $officer->name : old('name') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="position">Position <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="position" name="position" required
                                placeholder="Position..." value="{{ $officer ? $officer->position : old('position') }}">
                            @error('position')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="counter">Counter</label>
                            <select class="form-select" id="counter" data-trigger name="counter">
                                <option value="">-- Select Counter --</option>
                                @foreach ($counters as $counter)
                                    <option value="{{ $counter->id }}"
                                        @if ($officer && $officer->counter_id == $counter->id) selected @elseif ($counter->id == old('counter')) @endif>
                                        {{ $counter->name }} (Code: {{ $counter->code }})</option>
                                @endforeach
                            </select>
                            @error('counter')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="photo">Photo Profile</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            @if ($officer && $officer->photo)
                                <small>This is the photo file that has been saved : {{ $officer->photo }}</small>
                            @endif
                            @error('photo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="block">Block <span class="text-danger">*</span></label>
                            <select name="block" id="block" name="block" class="form-control" required>
                                <option value="">-- Select Block --</option>
                                <option value="Y"
                                    @if ($officer && $officer->block == 'Y') selected @elseif (old('block') == 'Y') selected @endif>
                                    Yes (Blocked)
                                </option>
                                <option value="N"
                                    @if ($officer && $officer->block == 'N') selected @elseif (old('block') == 'N')
                                selected @endif>
                                    No (Unblocked)
                                </option>
                            </select>
                            @error('active')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-database"></i>
                            Save Changes
                        </button>
                        <button type="reset" class="btn btn-warning">
                            <i class="ti ti-refresh"></i>
                            Reset
                        </button>
                        <a href="{{ route('officers.index') }}" class="btn btn-secondary">
                            <i class="ti ti-corner-up-left"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- [ Main Content ] end -->
        </div>
    </div>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var genericExamples = document.querySelectorAll("[data-trigger]");
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    searchEnabled: true,
                    allowHTML: true,
                    placeholderValue: "Pilih Opsi",
                    searchPlaceholderValue: "Pilih Opsi",
                });
            }
        });
    </script>
@endsection
