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
                <form action="{{ route('voice.store') }}" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{ $pageTitle }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-3">
                            <label class="form-label" for="apiKey">
                                API ResponsiveVoice Key <span class="text-danger">*</span>
                            </label>
                            <input type="apiKey" class="form-control" id="apiKey" name="apiKey" required
                                autocomplete="off" placeholder="API Key..."
                                value="{{ $voice ? Crypt::decrypt($voice->api_key) : old('apiKey') }}">
                            @error('apiKey')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="language">
                                Language ResponsiveVoice <span class="text-danger">*</span>
                            </label>
                            <select name="language" id="language" required class="form-control">
                                <option value="">-- Select Language --</option>
                                <option value="Indonesian Male"
                                    @if ($voice && $voice->language == 'Indonesian Male') selected @elseif (old('language') == 'Indonesian Male') selected @endif>
                                    Indonesian
                                    Male</option>
                                <option value="Indonesian Female"
                                    @if ($voice && $voice->language == 'Indonesian Female') selected @elseif (old('language') == 'Indonesian Female') selected @endif>
                                    Indonesian Female</option>
                            </select>
                            @error('language')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="sound">
                                Opening Sound <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" id="sound" name="sound" accept="audio/*">
                            @if ($voice && $voice->path_sound)
                                <small>This is the sound file that has been saved : {{ $voice->path_sound }}</small>
                            @endif
                            @error('sound')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-database"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
