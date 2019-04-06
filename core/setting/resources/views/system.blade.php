@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => ['admin.setting.system']]) !!}
    	<div class="col-xl-12 col-lg-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">{{ __('System Settings') }}</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<ul class="nav nav-tabs nav-linetriangle nav-justified">
							@foreach ($settings as $tab_id => $tab)
				                <li class="nav-item">
									<a class="nav-link @if ($loop->first) active @endif" id="{{ $tab_id }}" data-toggle="tab" href="#{{ $tab_id }}" aria-controls="activeIcon22" aria-expanded="true">
										<i class="ft-heart"></i> {{ $tab['name'] }}
									</a>
								</li>
				            @endforeach
						</ul>
						<div class="tab-content px-1 pt-1">
							<div role="tabpanel" class="tab-pane active" id="activeIcon22" aria-labelledby="activeIcon22-tab1" aria-expanded="true">
								<p>Macaroon candy canes tootsie roll wafer lemon drops liquorice jelly-o tootsie roll cake. Marzipan liquorice soufflé cotton candy jelly cake jelly-o sugar plum marshmallow. Dessert cotton candy macaroon chocolate sugar plum cake donut.</p>
							</div>
							<div class="tab-pane" id="linkIcon22" role="tabpanel" aria-labelledby="linkIcon22-tab1" aria-expanded="false">
								<p>Chocolate bar gummies sesame snaps. Liquorice cake sesame snaps cotton candy cake sweet brownie. Cotton candy candy canes brownie. Biscuit pudding sesame snaps pudding pudding sesame snaps biscuit tiramisu.</p>
							</div>
							<div class="tab-pane" id="dropdownOptIcon31" role="tabpanel" aria-labelledby="dropdownOptIcon31-tab1" aria-expanded="false">
								<p>Fruitcake marshmallow donut wafer pastry chocolate topping cake. Powder powder gummi bears jelly beans. Gingerbread cake chocolate lollipop. Jelly oat cake pastry marshmallow sesame snaps.</p>
							</div>
							<div class="tab-pane" id="dropdownOptIcon32" role="tabpanel" aria-labelledby="dropdownOptIcon32-tab1" aria-expanded="false">
								<p>Soufflé cake gingerbread apple pie sweet roll pudding. Sweet roll dragée topping cotton candy cake jelly beans. Pie lemon drops sweet pastry candy canes chocolate cake bear claw cotton candy wafer.</p>
							</div>
							<div class="tab-pane" id="linkIconOpt21" role="tabpanel" aria-labelledby="linkIconOpt21-tab1" aria-expanded="false">
								<p>Cookie icing tootsie roll cupcake jelly-o sesame snaps. Gummies cookie dragée cake jelly marzipan donut pie macaroon. Gingerbread powder chocolate cake icing. Cheesecake gummi bears ice cream marzipan.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    {!! Form::close() !!}
@stop
<!-- 

<div class="tabbable-custom tabbable-tabdrop">
        <ul class="nav nav-tabs" id="settings-tab">
            @foreach ($settings as $tab_id => $tab)
                <li @if ($loop->first) class="active" @endif>
                    <a data-toggle="tab" href="#{{ $tab_id }}">{{ $tab['name'] }}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content" style="overflow: inherit">
            @foreach ($settings as $tab_id => $tab)
                <div class="tab-pane @if ($loop->first) active @endif" id="{{ $tab_id }}">
                    @foreach ($tab['settings'] as $key => $setting)
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has($setting['attributes']['name'])) has-error @endif">
                            {!! Form::label($setting['attributes']['name'], $setting['label'], ['class' => 'control-label']) !!}
                            {!! Setting::render($setting) !!}
                            @if (array_key_exists('helper', $setting))
                                <span class="help-block">{!! $setting['helper'] !!}</span>
                            @endif
                            {!! Form::error($setting['attributes']['name'], $errors) !!}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    @endforeach
                </div>
            @endforeach
            <div class="clearfix"></div>
            <div class="text-center">
                <button type="submit" name="submit" value="save" class="btn btn-info">
                    <i class="fa fa-save"></i> {{ trans('bases::forms.save') }}
                </button>
            </div>
        </div>
    </div> -->