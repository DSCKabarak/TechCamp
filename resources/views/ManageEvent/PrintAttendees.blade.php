<html>
    <head>
        <title>
            @lang('Event.print_attendees_title')
        </title>

        <!--Style-->
       {!!Html::style('assets/stylesheet/application.css')!!}
        <!--/Style-->

        <style type="text/css">
            .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
                padding: 3px;
            }
            table {
                font-size: 13px;
            }
        </style>
    </head>
    <body style="background-color: #FFFFFF;" onload="window.print();">
        <div class="well" style="border:none; margin: 0;">
            {{ @trans("Event.n_attendees_for_event", ["num"=>$attendees->count(), "name"=>$event->title, "date"=>$event->start_date->format(config('attendize.default_datetime_format'))]) }}
            <br>
        </div>

        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>@lang("Attendee.name")</th>
                    <th>@lang("Attendee.email")</th>
                    <th>@lang("Order.ticket")</th>
                    <th>@lang("Order.order_ref")</th>
                    <th>@lang("Order.purchase_date")</th>
                    <th>@lang("Order.arrived")</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendees as $attendee)
                <tr>
                    <td>{{{$attendee->full_name}}}</td>
                    <td>{{{$attendee->email}}}</td>
                    <td>{{{$attendee->ticket->title}}}</td>
                    <td>{{{$attendee->order->order_reference}}}</td>
                    <td>{{$attendee->created_at->format(config("attendize.default_datetime_format"))}}</td>
                    <td><input type="checkbox" style="border: 1px solid #000; height: 15px; width: 15px;" /></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
