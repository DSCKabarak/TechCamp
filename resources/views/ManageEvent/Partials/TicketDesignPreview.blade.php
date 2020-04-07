{!! Html::style(asset('assets/stylesheet/ticket.css')) !!}
<style>
    .ticket {
        border: 1px solid {{$event->ticket_border_color}};
        background: {{$event->ticket_bg_color}} ;
        color: {{$event->ticket_sub_text_color}};
        border-left-color: {{$event->ticket_border_color}} ;
    }
    .ticket h4 {color: {{$event->ticket_text_color}};}
    .ticket .logo {
        border-left: 1px solid {{$event->ticket_border_color}};
        border-bottom: 1px solid {{$event->ticket_border_color}};

    }
</style>
<div class="ticket">
    <div class="logo">
        {!! Html::image(asset($image_path)) !!}
    </div>

    <div class="layout_even">
        <div class="event_details">
            <h4>@lang("Ticket.event")</h4>
            @lang("Ticket.demo_event")
            <h4>@lang("Ticket.organiser")</h4>
            @lang("Ticket.demo_organiser")
            <h4>@lang("Ticket.venue")</h4>
            @lang("Ticket.demo_venue")
            <h4>@lang("Ticket.start_date_time")</h4>
            @lang("Ticket.demo_start_date_time")
            <h4>@lang("Ticket.end_date_time")</h4>
            @lang("Ticket.demo_end_date_time")
        </div>

        <div class="attendee_details">
            <h4>@lang("Ticket.name")</h4>
            @lang("Ticket.demo_name")
            <h4>@lang("Ticket.ticket_type")</h4>
            @lang("Ticket.demo_ticket_type")
            <h4>@lang("Ticket.order_ref")</h4>
            @lang("Ticket.demo_order_ref")
            <h4>@lang("Ticket.attendee_ref")</h4>
            @lang("Ticket.demo_attendee_ref")
            <h4>@lang("Ticket.price")</h4>
            @lang("Ticket.demo_price")
        </div>
    </div>

    <div class="barcode">
        {!! DNS2D::getBarcodeSVG('hello', "QRCODE", 6, 6) !!}
    </div>
    @if($event->is_1d_barcode_enabled)
        <div class="barcode_vertical">
            {!! DNS1D::getBarcodeSVG(12211221, "C39+", 1, 50) !!}
        </div>
    @endif
    <div class="foot">
        @lang("Ticket.footer")
    </div>
</div>
