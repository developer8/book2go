@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {{ $options['wrapperAttrs'] }} >
    @endif
@endif

@if ($showLabel && $options['label'] !== false && $options['label_show'])
    {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
@endif

@if ($showField)
    {!! Form::editor($name, $options['value'], $options['attr']) !!}
    @include('core.base::forms.partials.help_block')
@endif

@include('core.base::forms.partials.errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
