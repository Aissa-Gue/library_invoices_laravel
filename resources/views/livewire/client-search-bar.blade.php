<div>
    <label for="client_id" class="form-label">الزبون</label>
    <input list="clients" class="form-control" name="client_id" id="client_id"
           placeholder="أدخل اسم الزبون"
           wire:model="client">
    <datalist id="clients">
        @foreach($clients as $client)
            <option
                value="{{$client->id .' # '. $client->last_name .' '. $client->first_name . ' بن ' . $client->father_name}}">
        @endforeach
    </datalist>
</div>
