<div>
    <label for="provider_id" class="form-label">المزود</label>
    <input list="providers" class="form-control" name="provider_id" id="provider_id"
           placeholder="أدخل اسم المزود"
           wire:model="provider">
    <datalist id="providers">
        @foreach($providers as $provider)
            <option
                value="{{$provider->id .' # '. $provider->last_name .' '. $provider->first_name . ' بن ' . $provider->father_name}}">
        @endforeach
    </datalist>
</div>
