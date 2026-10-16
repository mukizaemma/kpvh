@extends('layouts.adminBase')


@section('content')


        <!-- Sidebar Start -->
@include('admin.includes.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('admin.includes.navbar')
            <!-- Navbar End -->

            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Reservations</h6>
                        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search here" class="form-control" style="width: 200px;">

                    </div>
                    @if (session('success'))
                        <div class="alert alert-success text-start">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
<table class="table text-start align-middle table-bordered table-hover mb-0" id="reservationsTable">
    <thead>
        <tr class="text-dark">
            <th scope="col">Date</th>
            <th scope="col">Guest</th>
            <th scope="col">Phone</th>
            <th scope="col">Email</th>
            <th scope="col">Room</th>
            <th scope="col">Service</th>
            <th scope="col">Stay</th>
            <th scope="col">Request</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($reservations as $reservation)
        <tr>
            <td>{{ $reservation->created_at->format('Y-m-d H:i') }}</td>
            <td>{{ $reservation->names }}</td>
            <td>{{ $reservation->phone ?: '—' }}</td>
            <td>{{ $reservation->email ?: '—' }}</td>
            <td>{{ $reservation->room?->title ?? '—' }}</td>
            <td>{{ $reservation->facility?->title ?? '—' }}</td>
            <td>
                {{ $reservation->date_in ?: '—' }} to {{ $reservation->date_out ?: '—' }}
                <br>
                {{ $reservation->nights ?: '—' }} nights, {{ $reservation->guests ?: '—' }} guests
            </td>
            <td>{{ $reservation->message ?: '—' }}</td>
            <td>{{ $reservation->status }}<br><small>{{ $reservation->channel ?: 'Website' }}</small></td>
            <td>
                @if($reservation->guestWhatsappLink())
                    <a href="{{ $reservation->guestWhatsappLink() }}" target="_blank" rel="noopener" class="btn btn-success btn-sm mb-1">WhatsApp</a>
                @endif
                <a href="{{ route('deleteReservation', $reservation->id) }}"
                    class="btn btn-danger text-black btn-sm"
                    onclick="return confirm('Are you sure you want to delete this reservation?')">
                    Delete
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="10">No reservations yet.</td>
        </tr>
        @endforelse
    </tbody>

    <tfoot>
        <tr>
            <td colspan="10">
                {{ $reservations->links() }}
            </td>
        </tr>
    </tfoot>
</table>

                    </div>
                </div>
            </div>

        </div>
        <!-- Content End -->

        <script>
            function searchTable() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("searchInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("reservationsTable");
                tr = table.getElementsByTagName("tr");
        
                for (i = 1; i < tr.length; i++) {
                    txtValue = tr[i].textContent || tr[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else if (tr[i].parentElement.tagName !== "TFOOT") {
                        tr[i].style.display = "none";
                    }
                }
            }
        </script>

        @include('admin.includes.footer')

 @endsection