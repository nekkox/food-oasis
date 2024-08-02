<div class="tab-pane fade" id="v-pills-reservation" role="tabpanel" aria-labelledby="v-pills-reservation-tab">
    <div class="fp_dashboard_body">
        <h3>Reservations</h3>
        <div class="fp_dashboard_order">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr class="t_header">
                        <th>No</th>
                        <th>Reseration Id</th>
                        <th>Date/Time</th>
                        <th>Person</th>
                        <th>Status</th>

                    </tr>
                    @foreach ($reservations as $reservation)
                        <tr>
                            <td>
                                <h5>{{ ++$loop->index }}</h5>
                            </td>
                            <td>
                                {{ $reservation->reservation_id }}
                            </td>
                            <td>
                                {{ $reservation->date }} | {{ $reservation->time }}
                            </td>
                            <td>
                                {{ $reservation->persons }}
                            </td>
                            <td>
                                @if ($reservation->status === 'pending')
                                    <span class="active">Pending</span>
                                @elseif ($reservation->status === 'approved')
                                    <span class="active">Approved</span>
                                @elseif ($reservation->status === 'complete')
                                    <span class="complete">Completed</span>
                                @elseif ($reservation->status === 'cancel')
                                    <span class="cancel">Canceled</span>
                                @endif
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

