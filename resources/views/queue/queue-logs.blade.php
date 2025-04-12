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
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-2 mt-2">{{ $pageTitle }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="card">
                <div class="card-header">
                    <button data-pc-animate="fade-in-scale" data-bs-toggle="modal" data-bs-target="#animateModal1"
                        class="btn btn-primary"><i class="ph-duotone ph-trash"></i>
                        Delete Queue Logs
                    </button>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Queue Number</th>
                                    <th>Counter Name</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($queueLogs as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->queue_number }}</td>
                                        <td>{{ $item->counter_name }}</td>
                                        <td>{{ $item->created_at }}</td>
                                    </tr>
                                    @php
                                        $no++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <form action="{{ route('queue-logs.delete') }}" method="POST">
        <div class="modal fade modal-animate" id="animateModal1" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Queue Logs</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">
                        @method('DELETE')
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="firstDate">Fist Date
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="firstDate" id="firstDate"
                                placeholder="Choose Date..." readonly required value=" {{ old('firstDate') }}">
                            @error('firstDate')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="endDate">End Date
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="endDate" id="endDate"
                                placeholder="Choose Date..." readonly required value=" {{ old('endDate') }}">
                            @error('endDate')
                                <small class="text-danger mt-1">* {{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary shadow-2">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- datatable Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
    <script>
        // [ Zero Configuration ] start
        $('#simpletable').DataTable();

        (function() {
            const d_week1 = new Datepicker(document.querySelector("#firstDate"), {
                buttonClass: "btn",
                todayHighlight: true,
            });
            const d_week2 = new Datepicker(document.querySelector("#endDate"), {
                buttonClass: "btn",
                todayHighlight: true,
            });
        })();

        var animateModal1 = document.getElementById('animateModal1');
        animateModal1.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var recipient = button.getAttribute('data-pc-animate');
            var modalTitle = animateModal1.querySelector('.modal-title');
            // modalTitle.textContent = 'Animate Modal : ' + recipient;
            animateModal1.classList.add('anim-' + recipient);
            if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
                document.body.classList.add('anim-' + recipient);
            }
        });
        animateModal1.addEventListener('hidden.bs.modal', function(event) {
            removeClassByPrefix(animateModal1, 'anim-');
            removeClassByPrefix(document.body, 'anim-');
        });

        function removeClassByPrefix(node, prefix) {
            for (let i = 0; i < node.classList.length; i++) {
                let value = node.classList[i];
                if (value.startsWith(prefix)) {
                    node.classList.remove(value);
                }
            }
        }
    </script>
@endsection
