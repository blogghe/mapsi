<div class="form-group">
    <label for="name">{{__('text.name')}}:
        <input type="text" name="name" value="{{old('name') ?? $label->name}}" class="form-control">
    </label>
</div>
<div>{{$errors->first()}}</div>
@csrf
