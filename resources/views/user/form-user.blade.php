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
                <form action="{{ route('users.store') }}" method="post">
                    <div class="card-header">
                        <h4 class="card-title d-flex flex-row justify-content-between">
                            {{ $pageTitle }}
                            <a href="{{ route('users.index') }}" class="fs-5 float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('POST')
                        @if (Crypt::decrypt($paramForm) === 'update')
                            <div class="form-group mb-3" hidden>
                                <label class="form-label" for="id">User ID</label>
                                <input type="text" class="form-control" id="id" name="id"
                                    value="{{ Crypt::encrypt($user->id) }}" readonly>
                            </div>
                        @endif
                        <div class="form-group mb-3" hidden>
                            <label class="form-label" for="paramForm">Parameter</label>
                            <input type="text" class="form-control" id="paramForm" name="paramForm"
                                value="{{ $paramForm }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="officer">Officer <span class="text-danger">*</span></label>
                            <select class="form-select" id="officer" data-trigger name="officer">
                                <option value="">-- Select Officer --</option>
                                @foreach ($officers as $officer)
                                    <option value="{{ $officer->id }}"
                                        @if ($user && $user->officer_id == $officer->id) selected
                                    @elseif(old('officer') === $officer->id) selected @endif>
                                        {{ $officer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('officer')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="Email..." value="{{ $user ? $user->email : old('email') }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password...">
                            @if (Crypt::decrypt($paramForm) === 'update')
                                <small>Leave password it's blank if you don't want to change...</small>
                            @endif
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="role">Role <span class="text-danger">*</span></label>
                            <select name="role" id="role" name="role" class="form-control" required>
                                <option value="">-- Select Role --</option>
                                <option value="{{ \App\Enum\RolesEnum::ADMIN->value }}"
                                    @if ($user && $user->role === \App\Enum\RolesEnum::ADMIN->value) selected
                                @elseif(old('role') === \App\Enum\RolesEnum::ADMIN->value) selected @endif>
                                    {{ \App\Enum\RolesEnum::ADMIN->value }}
                                </option>
                                <option value="{{ \App\Enum\RolesEnum::OFFICER->value }}"
                                    @if ($user && $user->role === \App\Enum\RolesEnum::OFFICER->value) selected
                                @elseif(old('role') === \App\Enum\RolesEnum::OFFICER->value) selected @endif>
                                    {{ \App\Enum\RolesEnum::OFFICER->value }}
                                </option>
                            </select>
                            @error('role')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="block">Block <span class="text-danger">*</span></label>
                            <select name="block" id="block" name="block" class="form-control" required>
                                <option value="">-- Select Block --</option>
                                <option value="Y"
                                    @if ($user && $user->block == 'Y') selected @elseif (old('block') == 'Y') selected @endif>
                                    Yes (Blocked)
                                </option>
                                <option value="N"
                                    @if ($user && $user->block == 'N') selected @elseif (old('block') == 'N')
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
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
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
