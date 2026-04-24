<div class="pos-tab-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="checkbox">
                <br>
                  <label>
                    {!! Form::checkbox('pos_settings[customer_display_screen]', 1,  
                        !empty($pos_settings['customer_display_screen']) , 
                    [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.enable_customer_display_screen' ) }}
                  </label>
                  <p class="help-block"><i> @lang('lang_v1.customer_display_instraction')</i></p>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('customer_display_link', 'Customer display link:') !!}
                <div class="input-group">
                    <input type="text"
                        id="customer_display_link"
                        class="form-control"
                        readonly
                        value="{{ route('pos_display') }}">
                    <span class="input-group-btn">
                        <a href="{{ route('pos_display') }}"
                           target="_blank"
                           class="btn btn-primary"
                           id="open_customer_display_link">
                           Open now display
                        </a>
                    </span>
                    <span class="input-group-btn">
                        <button type="button"
                            class="btn btn-default"
                            id="copy_customer_display_link">
                            Copy link
                        </button>
                    </span>
                </div>
                <p class="help-block"><i>Open this URL in a separate tab/screen for customer-facing display.</i></p>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <div class="checkbox">
                  <label>
                    {!! Form::checkbox('pos_settings[customer_display_show_promo_blocks]', 1, !isset($pos_settings['customer_display_show_promo_blocks']) || !empty($pos_settings['customer_display_show_promo_blocks']), [ 'class' => 'input-icheck']); !!}
                    Show promotion and loyalty widgets on customer display
                  </label>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('display_screen_heading', __('lang_v1.display_screen_heading') . ':') !!}
                 {!! Form::textarea('pos_settings[display_screen_heading]', isset($pos_settings['display_screen_heading']) ? $pos_settings['display_screen_heading'] : null, ['class' => 'form-control', 'id' => 'display_screen_heading']); !!}
            </div>
        </div>
        @for ($i = 1; $i <= 10; $i++)
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label("carousel_image_$i", __('lang_v1.carousel_image', ['number' => $i]) . ':') !!}
                    {!! Form::file("carousel_image_$i", ['accept' => 'image/*', 'class' => 'carousel_image']) !!}
                    <p class="help-block"><i> @lang('lang_v1.image_help')</i></p>
                </div>
            </div>
        @endfor
    </div>
</div>
<script>
$(document).off('click', '#copy_customer_display_link').on('click', '#copy_customer_display_link', function() {
    var $input = $('#customer_display_link');
    $input.trigger('focus');
    $input.trigger('select');

    try {
        var copied = document.execCommand('copy');
        if (copied) {
            toastr.success('Customer display link copied');
            return;
        }
    } catch (e) {}

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText($input.val())
            .then(function() {
                toastr.success('Customer display link copied');
            })
            .catch(function() {
                toastr.error('Failed to copy link');
            });
    } else {
        toastr.error('Failed to copy link');
    }
});
</script>