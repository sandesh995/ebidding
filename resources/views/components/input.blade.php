<div class="form-group @if ($margin) mb-3 @endif">
    @if (!empty($text))
        <label class="form-label" for="{{ $clean_field }}">
            {!! $text !!}
            @if ($required ?? false)
                <x-required />
            @endif
        </label>
    @endif

    @if (!empty($type) && strtolower($type) == 'textarea')
        <textarea data-bs-toggle="autosize" id="{{ $clean_field }}" name="{{ $field }}"
            class="form-control @error($field) is-invalid @enderror" @if ($required ?? false) required @endif>{{ $old ?? true ? old($field, $current ?? null) : '' }}</textarea>
    @elseif(!empty($type) && strtolower($type) == 'select')
        <select
            name="{{ $field }}"
            id="{{ $clean_field }}"
            class="form-control form-select @error($field) is-invalid @enderror"
            @if($autofocus) autofocus @endif
            @if($multiple) multiple="multiple" @endif
        >
        @if($empty)
            <option value="">Choose One...</option>
        @endif

        @if(empty($key))
            @foreach($options as $item)
            <option
                value="{{ $item }}"
                @if($multiple)
                    @if(in_array($item, $current)) selected @endif
                @else
                    @if($current == $item) selected @endif
                @endif
            >{{ $item }}</option>
            @endforeach
        @else
            @foreach($options as $item)
            <option
                value="{{ $item[$key] }}"
                @if($multiple)
                    @if(in_array($item[$key], $current)) selected @endif
                @else
                    @if($current == $item[$key]) selected @endif
                @endif
            >{{ $item[$value] }}</option>
            @endforeach
        @endif
        </select>
    @else
        <div class="input-group">
            <input id="{{ $clean_field }}" type="{{ $type ?? 'text' }}" name="{{ $field }}"
                class="form-control @if (!empty($class)) {{ $class }} @endif @error($field) is-invalid @enderror" @if ($old ?? true)
            value="{{ old($field, $current ?? null) }}"
    @endif
    @if ($required ?? false)
        required
    @endif

    @if ($multiple ?? false && $type == "file")
        multiple="multiple"
    @endif

    @if($autofocus ?? false)
        autofocus
    @endif
    />
    @if (empty($text) && ($required ?? false))
        <div class="input-group-append" style="background:transparent!important">
            <span class="input-group-text" style="background:transparent!important">
                <x-required />
            </span>
        </div>
    @endif
</div>
@endif

@if ($error ?? true)
    @error($field)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
@endif
</div>
