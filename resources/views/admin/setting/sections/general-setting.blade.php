<div class="tab-pane fade active show" id="general-setting" role="tabpanel"
     aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form method="post" action="{{route('admin.general-setting.update')}}">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="site_name">Site Name</label>
                    <input type="text" class="form-control" name="site_name" id="site_name"
                           value="{{config('settings.site_name')}}">
                </div>
                <div class="form-group">
                    <label for="site_default_currency">Default Currency</label>
                    <select name="site_default_currency" id="site_default_currency"
                            class="select2 form-control">
                        <option value="">Select</option>
                        @foreach(config('currencies.currency_list') as $currency_name => $currency_short)
                            <option
                                @selected(config('settings.site_default_currency') === $currency_short) value="{{$currency_short}}">{{$currency_short}}</option>
                        @endforeach

                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="site_currency_icon">Currency Icon</label>
                            <input type="text" class="form-control"
                                   name="site_currency_icon" id="site_currency_icon"
                                   value="{{config('settings.site_currency_icon')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="site_currency_icon_position">Currency Icon
                                Position</label>
                            <select name="site_currency_icon_position"
                                    id="site_currency_icon_position"
                                    class="select2 form-control">
                                <option
                                    @selected(config('settings.site_currency_icon_position') === 'right') value="right">
                                    Right
                                </option>
                                <option
                                    @selected(config('settings.site_currency_icon_position') === 'left') value="left">
                                    Left
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
