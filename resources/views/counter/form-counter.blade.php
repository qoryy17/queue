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
                <form action="{{ route('counters.store') }}" method="post">
                    <div class="card-header">
                        <h4 class="card-title d-flex flex-row justify-content-between">
                            {{ $pageTitle }}
                            <a href="{{ route('counters.index') }}" class="fs-5 float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('POST')
                        @if (Crypt::decrypt($paramForm) === 'update')
                            <div class="form-group mb-3" hidden>
                                <label class="form-label" for="id">Counter ID</label>
                                <input type="text" class="form-control" id="id" name="id"
                                    value="{{ Crypt::encrypt($counter->id) }}" readonly>
                            </div>
                        @endif
                        <div class="form-group mb-3" hidden>
                            <label class="form-label" for="paramForm">Parameter</label>
                            <input type="text" class="form-control" id="paramForm" name="paramForm"
                                value="{{ $paramForm }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="code">Counter Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="code" name="code" required
                                placeholder="Counter Code..." value="{{ $counter ? $counter->code : old('code') }}">
                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Counter Name <span class="text-danger">*</span></label>
                            <input type="name" class="form-control" id="name" name="name" required
                                placeholder="Counter Name..." value="{{ $counter ? $counter->name : old('name') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="description">Description <span
                                    class="text-danger">*</span></label>
                            <textarea name="description" id="description" required placeholder="Description..." class="form-control">{{ $counter ? $counter->description : old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" name="status" class="form-control" required>
                                <option value="">-- Select Status Counter --</option>
                                <option value="{{ \App\Enum\CounterEnum::OPEN->value }}"
                                    @if ($counter && $counter->status == \App\Enum\CounterEnum::OPEN->value) selected @elseif (old('status') == \App\Enum\CounterEnum::OPEN->value) selected @endif>
                                    {{ \App\Enum\CounterEnum::OPEN->value }}
                                </option>
                                <option value="{{ \App\Enum\CounterEnum::CLOSED->value }}"
                                    @if ($counter && $counter->status == \App\Enum\CounterEnum::CLOSED->value) selected @elseif (old('status') == \App\Enum\CounterEnum::CLOSED->value) selected @endif>
                                    {{ \App\Enum\CounterEnum::CLOSED->value }}
                                </option>
                                <option value="{{ \App\Enum\CounterEnum::BREAK->value }}"
                                    @if ($counter && $counter->status == \App\Enum\CounterEnum::BREAK->value) selected @elseif (old('status') == \App\Enum\CounterEnum::BREAK->value) selected @endif>
                                    {{ \App\Enum\CounterEnum::BREAK->value }}
                                </option>
                                <option value="{{ \App\Enum\CounterEnum::ENABLED->value }}"
                                    @if ($counter && $counter->status == \App\Enum\CounterEnum::ENABLED->value) selected @elseif (old('status') == \App\Enum\CounterEnum::ENABLED->value) selected @endif>
                                    {{ \App\Enum\CounterEnum::ENABLED->value }}
                                </option>
                                <option value="{{ \App\Enum\CounterEnum::DISABLED->value }}"
                                    @if ($counter && $counter->status == \App\Enum\CounterEnum::DISABLED->value) selected @elseif (old('status') == \App\Enum\CounterEnum::DISABLED->value) selected @endif>
                                    {{ \App\Enum\CounterEnum::DISABLED->value }}
                                </option>
                            </select>
                            @error('status')
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
                        <a href="{{ route('counters.index') }}" class="btn btn-secondary">
                            <i class="ti ti-corner-up-left"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
