<section id="details" class="container">
    <div class="row">
        <h1 class="section_head">
            @lang("Public_ViewEvent.event_details")
        </h1>
    </div>
    <div class="row">
        <?php /*
        @if($event->images->count())
        <div class="col-md-7">
            <div class="content event_details" property="description">
                {!! Markdown::parse($event->description) !!}
            </div>
        </div>
        <div class="col-md-5">
            <div class="content event_poster">
                <img alt="{{$event->title}}" src="{{config('attendize.cdn_url_user_assets').'/'.$event->images->first()['image_path']}}" property="image">
            </div>
        </div>
        @else */ ?>
        <div class="col-md-12">
            <div class="content event_details" property="description">
                {!! Markdown::parse($event->description) !!}
            </div>
        </div>
        <?php /*@endif*/ ?>
    </div>
</section>